<?php

namespace HLC\AP\Controller\Course;

use DateTime;
use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

class CourseController
{
    private string $courseId;
    private string $educationCenter;
    private string $startYear;
    private int $endYear;
    private string $description;
    /** @var string[] $errors */
    private array $errors = [];
    protected ?User $user;
    /** @var Course[] $errors */
    protected array $courses;
    protected array $notJoinedCourses;
    public const STUDENT_HEADERS = [
        "Course ID",
        "Education Center",
        "Start year",
        "End year",
        "Description"
    ];

    public const  COURSE_BUTTONS = [
        [
            'title' => 'Edit',
            'onclick' => 'edit',
            'iconClass' => 'zmdi-edit',
            'name' => 'edit'
        ],
        [
            'title' => 'Leave',
            'onclick' => 'leave',
            'iconClass' => 'zmdi-redo',
            'name' => 'delete'
        ],
        [
            'title' => 'Delete',
            'onclick' => 'remove',
            'iconClass' => 'zmdi-delete',
            'name' => 'delete'
        ],

    ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CourseRepositoryInterface $courseRepository,
        private CourseTeacherRepositoryInterface $courseTeacherRepository
    )
    {

        if (!isset($_SESSION['courseOrder'])) {
            $_SESSION['courseOrder'] = $this->setOrder();
        }
    }

    public function execute(): string
    {
        if (!isset($_SESSION['uid'])) header("Location: /");

        $currentUserID = $_SESSION['uid'];
        $this->user = $this->userRepository->getByDni($currentUserID);

        $orderBy = $_SESSION['courseOrder'];

        if ($this->user->getType() === 'P') {
            $this->notJoinedCourses = $this->courseRepository->getNotJoinedCourse($this->user->getIdentificationDocument());
            $this->courses = $this->courseRepository->getCoursesById($this->user->getIdentificationDocument(), $orderBy);
        } else {
            $this->courses = $this->courseRepository->getPupilCourse($this->user->getIdentificationDocument());
        }

        set_url('course');
        return require __DIR__ . '/../../Views/Course/Course.php';
    }

    public function leave()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['courseId'])
        ) {
            $courseId = (int)$_POST['courseId'];
            $this->leaveCourse($courseId);
        }
    }

    public function join()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['courseToJoin'])
        ) {
            $courseId = (int)$_POST['courseToJoin'];
            $this->joinCourse($courseId);
        }
    }

    public function orderBy()
    {
        $_SESSION['courseOrder'] = $this->setOrder($_POST['orderBy']);
        $this->execute();
    }

    public function delete()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['courseId'])
        ) {
            $courseId = $_POST['courseId'];
            $this->deleteCourse($courseId);
        }
        $this->execute();
    }

    public function fetchCourse()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['courseId'])
        ) {
            $course = $this->courseRepository->getById($_POST['courseId']);

            print(json_encode(
                [
                    'courseId' => $course->getCourseId(),
                    'educationCenter' => $course->getEducationCenter(),
                    'startYear' => $course->getYearStart(),
                    'endYear' => $course->getYearEnd(),
                    'description' => $course->getDescription()
                ]
            ));
        }
    }

    public function save()
    {
        $this->validateFields();
        if (empty($this->errors)) {
            $this->insertCourse();
        }

        $this->execute();
    }

    private function validateEducationCenter(): void
    {
        if (empty($_POST["educationCenter"]) || strlen($_POST["educationCenter"]) < 4) {
            array_push($this->errors, ErrorsMessages::getError("educationCenter:invalid"));
            return;
        }
        $this->educationCenter = self::sanitize($_POST["educationCenter"]);
    }

    private function validateYear(): void
    {
        $date = new DateTime();
        $actualDate = $date->getTimestamp();
        $year = date('Y', $actualDate);

        if (empty($_POST["endYear"]) || empty($_POST["startYear"])) {
            array_push($this->errors, ErrorsMessages::getError("yearEmpty:invalid"));
        }

        if ($_POST["endYear"] < $year || $_POST["endYear"] > 2050 ||
            $_POST["startYear"] < 2000 || $_POST["startYear"] > 2050) {
            array_push($this->errors, ErrorsMessages::getError("year:invalid"));
        }

        if ($_POST["startYear"] > $_POST["endYear"]) {
            array_push($this->errors, ErrorsMessages::getError("yearStart:invalid"));
        }

        if (!empty($this->errors)) {
            return;
        }

        $this->endYear = (int)self::sanitize($_POST["endYear"]);
        $this->startYear = (int)self::sanitize($_POST["startYear"]);
    }

    private function validateDescription(): void
    {
        if (empty($_POST["description"]) || strlen($_POST["description"]) < 3) {
            array_push($this->errors, ErrorsMessages::getError("description:invalid"));
            return;
        }

        $this->description = self::sanitize($_POST["description"]);
    }

    private static function sanitize(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);

        return htmlspecialchars($data);
    }

    private function insertCourse(): void
    {
        $this->courseId = (int)$_POST['courseId'];
        $resp = $this->courseRepository->save(
            $this->courseId,
            $this->educationCenter,
            $this->startYear,
            $this->endYear,
            $this->description
        );
        if ($resp === 'insert') {
            $courseId = $this->courseRepository->getLastCourseInserted();
            $teacherID = $_SESSION['uid'];
            $this->courseTeacherRepository->insert($courseId, $teacherID);
        }
    }

    public function validateFields(): void
    {
        $this->validateEducationCenter();
        $this->validateDescription();
        $this->validateYear();
    }

    private function deleteCourse(string $courseId)
    {
        $this->courseTeacherRepository->deleteByCourse($courseId);
        $this->courseRepository->delete($courseId);
    }

    public function setOrder($order = 'courseId'): string
    {
        return match ($order) {
            'yearStart' => 'a_inicio',
            'yearEnd' => 'a_fin',
            default => 'codcurso'
        };
    }

    private function joinCourse(int $courseId)
    {
        $this->courseTeacherRepository->insert($courseId, $_SESSION['uid']);
    }

    private function leaveCourse(int $courseId)
    {
        $this->courseTeacherRepository->deleteByCourse($courseId);
    }
}
