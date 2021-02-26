<?php

namespace HLC\AP\Controller\Course;

use DateTime;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

class CourseController
{
    private string $educationCenter;
    private string $startYear;
    private int $endYear;
    private string $description;
    /** @var string[] $errors */
    private array $errors = [];
    protected ?User $user;
    /** @var Course[] $errors */
    protected array $courses;
    public const COURSE_HEADERS = [
                "Course ID",
                "Education Center",
                "Start year",
                "End year",
                "Description"
            ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CourseRepositoryInterface $courseRepository,
        private CourseTeacherRepositoryInterface $courseTeacherRepository
    )
    {
        $currentUserID = $_SESSION['uid'];
        $this->user = $this->userRepository->getByDni($currentUserID);
    }

    public function execute(): string
    {
        $this->courses = $this->courseRepository->getCoursesById($this->user->getIdentificationDocument());

        return require __DIR__ . '/../../Views/Course/Course.php';
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
        if (empty($_POST["description"]) || strlen($_POST["description"]) < 4) {
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

    public function insertCourse(): void
    {
        $this->courseRepository->insert(
            0,
            $this->educationCenter,
            $this->startYear,
            $this->endYear,
            $this->description
        );
        $courseId = $this->courseRepository->getLastCourseInserted();
        $teacherID = $this->user->getIdentificationDocument();
        $this->courseTeacherRepository->insert($courseId, $teacherID);
    }

    public function validateFields(): void
    {
        $this->validateEducationCenter();
        $this->validateDescription();
        $this->validateYear();
    }
}
