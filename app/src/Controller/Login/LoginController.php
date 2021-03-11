<?php

namespace HLC\AP\Controller\Login;

use HLC\AP\Controller\Task\TaskController;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

final class LoginController
{
    private string $email;
    private string $password;
    /** @var string[] $errors */
    private array $errors;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskController $taskController
    )
    {
        $this->errors = [];
    }

    public function execute(): string
    {

        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST["submit"])) {
            return $this->errorsView();
        }

        $this->validateEmail();
        $this->validatePassword();

        if (!empty($this->errors)) {
            return $this->errorsView();
        }

        /** @var User|null $user */
        $user = $this->userRepository->get($this->email, $this->password);

        if (null === $user) {
            array_push($this->errors, ErrorsMessages::getError("login:invalid"));
            return $this->errorsView();
        }

        if (isset($_POST["remember"]) && $_POST["remember"] == 'remember') {
            setcookie("loggedId", $user->getIdentificationDocument(), time() + 60 * 60 * 24 * 30, "/");
        }

        $_SESSION['uid'] = $user->getIdentificationDocument();
        session_write_close();


        return $this->taskController->execute();
    }

    private function validateEmail(): void
    {
        if (empty($_POST["email"])
            || !preg_match("/[-0-9a-zA-Z.+]+@[-0-9a-zA-Z.+]+.[a-zA-Z]{2,4}/", $_POST['email'])
        ) {
            array_push($this->errors, ErrorsMessages::getError("email:invalid"));
            return;
        }
        $this->email = self::sanitize($_POST['email']);
    }

    private function validatePassword(): void
    {
        if (empty($_POST["password"]) || strlen($_POST["password"]) < 8) {
            //Check if the name only contains letters.
            array_push($this->errors, ErrorsMessages::getError("password:invalid"));
            return;
        }
        $this->password = self::sanitize($_POST["password"]);
    }

    private function errorsView(): string {
        echo("<script>history.replaceState({},'','/Login');</script>");

        return require __DIR__ . '/../../Views/Auth/Login.php';
    }

    private static function sanitize(string $data): string
    {
        $data = trim($data); // Delete All spaces before and after the data
        $data = stripslashes($data); // Delete backslashes \
        $data = htmlspecialchars($data); // Translate special characters in HTML entities
        return $data;
    }
}
