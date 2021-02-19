<?php

namespace HLC\AP\Controller\Login;

use HLC\AP\Domain\User\User;
use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\ErrorsMessages;

$pdoUserRepository = new PdoUserRepository();
$errors = array();
$email = '';
$password = '';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    validateEmail();
    validatePassword();

    //only if there have been no errors in the form, the entries are validated;
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        /** @var User|null $user */
        $user = $pdoUserRepository->get($_POST["email"], $_POST["password"]);
        if ($user != null) {
            if (isset($_POST["remember"]) && $_POST["remember"]  == 'remember') {
                setcookie("loggedId", $user->getIdentificationDocument(), time() + 60 * 60 * 24 * 30, "/");
            }
            $_SESSION['uid'] = $user->getIdentificationDocument();
            session_write_close();
            header("Location: ../../views/task/tarea.php");
        } else {
            $_SESSION['error'] = ErrorsMessages::getError("login:invalid");
            session_write_close();
            header('location: ../../views/auth/login.php');
        }

    } else {
        $_SESSION['error'] = $errors;
        session_write_close();
        header('location: ../../views/auth/login.php');
    }

} else {
    header('location: ../../views/auth/login.php');
}
