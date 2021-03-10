<?php

namespace HLC\AP\Controller\Student;

use DateTime;
use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Domain\Student\Student;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

class StudentController
{
    private string $courseId;
    /** @var string[] $errors */
    private array $errors = [];
    protected ?User $user;
    /** @var Student[] $students */
    protected array $students;

    public const STUDENT_HEADERS = [
        "Student ID",
        "Email",
        "Name",
        "Start date",
        "Course ID",
        "Date of birth"
    ];

    public const  STUDENT_BUTTONS = [
        [
            'title' => 'Edit',
            'onclick' => 'edit',
            'iconClass' => 'zmdi-edit',
            'name' => 'edit'
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
        private LoginController $loginController
    )
    {
        if (!isset($_SESSION['studentOrder'])) {
            $_SESSION['studentOrder'] = $this->setOrder();
        }
    }

    public function execute(): string
    {
        if (!isset($_SESSION['uid'])) {
            return $this->loginController->execute();
        }

        $currentUserID = $_SESSION['uid'];
        $this->user = $this->userRepository->getByDni($currentUserID);
        $orderBy = $_SESSION['studentOrder'];

        $this->students = $this->userRepository->getStudents($currentUserID, $orderBy);

        $this->setUrl();
        return require __DIR__ . '/../../Views/Student/Student.php';
    }


    public function orderBy()
    {
        $_SESSION['studentOrder'] = $this->setOrder($_POST['orderBy']);
        $this->execute();
    }

    public function delete()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['studentId'])
        ) {
            $this->deleteStudent($_POST['studentId']);

        }
        $this->execute();
    }

    public function fetchUser()
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


    private static function sanitize(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }

    public function validateFields(): void
    {
        //TODO
    }

    public function setUrl(): void
    {
        $_SERVER['REQUEST_URI'] = "/Students";
        echo("<script>history.replaceState({},'','/Student');</script>");
    }

    public function setOrder($order = 'name'): string
    {
        return match ($order) {
            'StartDate' => 'f_alta',
            'courseId' => 'codcurso',
            default => 'nombre'
        };
    }

    private function deleteStudent(string $studentId)
    {
        $this->userRepository->delete($studentId);
        $this->userRepository->deleteStudent($studentId);
    }
}
