<?php

namespace HLC\AP\Controller\Register;

use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\ErrorsMessages;

$userQ = new PdoUserRepository();
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    validateEmail();
    validatePassword();

    //only if there have been no errors in the form, the entries are validated;
    session_start();
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        if ($userQ->checkEmail($_POST["email"])) {
            $_SESSION['error'] = ErrorsMessages::getError("email:repeat");
            session_write_close();
            header("Location: ../../Views/auth/login.php");
        } else {
            if ($userQ->checkDni($_POST["dni"])) {
                $_SESSION['error'] = ErrorsMessages::getError("dni:repeat");
                session_write_close();
                header("Location: ../../Views/auth/login.php");
            } else {
                $date = new DateTime();
                $r = $userQ->save($_POST["dni"], $_POST["email"], $_POST["alias"], $_POST["password"], $_POST["name"], date("Y-m-d", $date->getTimestamp()), $_POST["tipo"]);
                if ($r) {
                    $user = $userQ->getByDni($_POST["dni"]);
                    if (isset($_POST["remember"]) && $_POST["remember"]  == 'remember') {
                        setcookie("loggedId", $user->getIdentificationDocument(), time() + 60 * 60 * 24 * 30, "/");
                    }
                    $_SESSION['uid'] = $user->getIdentificationDocument();
                    session_write_close();
                    header("Location: ../../Views/task/tarea.php");
                }
            }
        }
    } else {
        $_SESSION['error'] = $errors;
        session_write_close();
        header('location: ../../Views/auth/login.php');
    }
} else {
    header('location: ../../Views/auth/login.php');
}
