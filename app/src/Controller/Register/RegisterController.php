<?php

namespace HLC\AP\Controller\Register;

use DateTime;
use HLC\AP\Controller\Course\CourseController;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

final class RegisterController
{
    private string $identificationDocument;
    private string $name;
    private string $nickName;
    private string $email;
    private string $password;
    private string $courseId;
    private string $birthDate;
    private string $type;

    /** @var string[] $errors */
    private array $errors;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private CourseRepositoryInterface $courseRepository,
        private CourseController $courseController
    )
    {
        $this->errors = [];
    }


    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST["submit"])) {
            return $this->showView();
        }

        $this->validateFields();

        if (!empty($this->errors)) {
            return $this->showView();
        }

        $this->registerUser();

        $this->saveUserData();

        set_url('/Course');
        return $this->courseController->execute();
    }

    private function validateType()
    {
        if (
            !isset($_POST["type"]) ||
            empty($_POST["type"])
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("type:invalid"));
            return;
        }

        $this->type = self::sanitize($_POST['type']);
    }

    private function validateIdentificationDocument()
    {
        if (
            !isset($_POST["identificationDocument"]) ||
            empty($_POST["identificationDocument"]) ||
            !preg_match("/[0-9]{8}[A-Za-z]/", $_POST['identificationDocument'])
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("identificationDocument:invalid"));
            return;
        }

        $this->identificationDocument = self::sanitize($_POST['identificationDocument']);

        $idRepeat = $this->userRepository->checkDni($this->identificationDocument);

        if ($idRepeat === true) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("identificationDocument:repeat"));
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


    private function validateDateBirth()
    {
        if ($this->type === 'p') {
            return;
        }
        $date = new DateTime();
        $actualDate = $date->getTimestamp();
        $year = date('Y', $actualDate);
        if (
            !isset($_POST["dateBirth"]) ||
            empty($_POST["dateBirth"])
        ) {
            array_push(
                $this->errors,
                ErrorsMessages::getError("date:invalid"));
            return;
        }

        if ($_POST["dateBirth"] >= $year || $_POST["dateBirth"] <= 1900) {
            array_push($this->errors, ErrorsMessages::getError("date:invalid"));
            return;
        }

        $this->birthDate = self::sanitize($_POST['dateBirth']);
    }

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

    private function validatePassword(): void
    {
        if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
            array_push($this->errors, ErrorsMessages::getError("password:invalid"));
            return;
        }

        $this->password = self::sanitize($_POST["password"]);
    }

    private function showView(): string
    {
        return require __DIR__ . '/../../Views/Auth/Register.php';
    }

    private static function sanitize(string $data): string
    {
        $data = trim($data); // Delete All spaces before and after the data
        $data = stripslashes($data); // Delete backslashes \
        $data = htmlspecialchars($data); // Translate special characters in HTML entities
        return $data;
    }

    private function registerUser()
    {
        $date = new DateTime();
        $actualDate = $date->getTimestamp();
        $currentdate = date('y/m/d', $actualDate);

        //Insert user in User table
        $this->userRepository->save(
            $this->identificationDocument,
            $this->email,
            $this->nickName,
            $this->password,
            $this->name,
            $currentdate,
            '',
            $this->type
        );

        //Insert pupil or teacher.
        if ($this->type === 'a') {
            $this->userRepository->savePupil(
                $this->identificationDocument,
                $this->birthDate,
                $this->courseId
            );
        } else {
            $this->userRepository->saveTeacher($this->identificationDocument);
        }
    }

    public function saveUserData(): void
    {
        if (isset($_POST["remember"]) && $_POST["remember"] == 'remember') {
            //Save 30 days
            setcookie("loggedId", $this->identificationDocument, time() + 60 * 60 * 24 * 30, "/");
        }

        //Save 1 day
        setcookie("loggedId", $this->identificationDocument, time() + 60 * 60 * 24, "/");
        $_SESSION['uid'] = $this->identificationDocument;
        session_write_close();
    }

    public function validateFields(): void
    {
        $this->validateIdentificationDocument();
        $this->validateType();
        $this->validateEmail();
        $this->validateDateBirth();
        $this->validateNickName();
        $this->validateName();
        $this->validatePassword();
        $this->validateCourse();
    }
}

