<?php

namespace HLC\AP\Controller\Student;

use DateTime;
use HLC\AP\Controller\Course\CourseController;
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
        private LoginController $loginController,
        private CourseController $courseController
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

        if ($this->user->getType() === 'A') return $this->courseController->execute();

        $orderBy = $_SESSION['studentOrder'];

        $this->students = $this->userRepository->getStudents($currentUserID, $orderBy);

        set_url('student');
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
            $student = $this->userRepository->getStudent($_POST['studentId']);
            print(json_encode(
                [
                    "name" => $student->getName(),
                    "nick" => $student->getNick(),
                    "email" => $student->getEmail(),
                    "courseId" => $student->getCourseId(),
                    "dni" => $student->getIdentificationDocument()
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
        $this->validateName();
        $this->validateCourse();
        $this->validateNickName();
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
        if(
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

    public function save(): void
    {
        $this->validateFields();
        if (empty($this->errors)) {
            $this->userRepository->updateStudent(
                $_POST['dni'],
                intval($_POST['courseId'])
            );

            $this->userRepository->updateUser(
                $_POST['dni'],
                $_POST['name'],
                $_POST['nick'],
            );
        }
        $this->execute();
    }
}
