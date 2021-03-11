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
        ]
    ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CourseRepositoryInterface $courseRepository,
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
            && isset($_POST['studentId'])
        ) {
            $student = $this->userRepository->getByDni( $_POST['studentId']);
            print(json_encode(
                [
                    "Name"=>$student->getName(),
                    "Nick"=>$student->getNick(),
                    "Email"=>$student->getEmail(),
                    "Course ID"=>$student->getCourseId()
                ]
            ));
        }
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
        //First delete student from 'alumno' table;
        $this->userRepository->deleteStudent($studentId);
        $this->userRepository->delete($studentId);
    }

    //Validators

    private function validateEmail(): void
    {
        if (empty($_POST["email"])
            || !preg_match("/[-0-9a-zA-Z.+]+@[-0-9a-zA-Z.+]+.[a-zA-Z]{2,4}/", $_POST['email'])
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("email:invalid")
            );

            return;
        }
        $this->email = self::sanitize($_POST['email']);

        $emailRepeat = $this->userRepository->checkEmail($this->email);

        if ($emailRepeat === true) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("email:repeat"));
        }
    }

    private function validateName()
    {
        if (
            !isset($_POST["name"]) ||
            empty($_POST["name"]) ||
            strlen($_POST["name"]) < 4
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("userName:invalid"));
            return;
        }

        $this->name = self::sanitize($_POST['name']);
    }

    private function validateNickName()
    {
        if (
            !isset($_POST["nick"]) ||
            empty($_POST["nick"]) ||
            strlen($_POST["nick"]) < 4
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("nickName:invalid"));
            return;
        }

        $this->nickName = self::sanitize($_POST['nick']);
    }

    private function validateCourse()
    {
        if ($this->type === 'p') {
            return;
        }

        if (
            !isset($_POST["courseId"]) ||
            empty($_POST["courseId"])
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("courseID:invalid"));
            return;
        }

        $this->courseId = self::sanitize($_POST['courseId']);

        $courseRepeat = $this->courseRepository->checkCourseId($this->courseId);

        if ($courseRepeat === false) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("courseID:notFound"));
        }
    }
}
