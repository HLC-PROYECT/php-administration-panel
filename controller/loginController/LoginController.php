<?php

require '../../domain/user/userRepositoryInterface.php';
require '../../domain/user/user.php';
require '../../respository/PdoUserRepository.php';
require '../../utils/errorsMessages.php';
require '../../utils/Medoo.php';

use errorsMessages\errorsMessages;
use User\PdoUserRepository;

$errorsMessages = new errorsMessages();
$userQ = new PdoUserRepository();
$errors = array();
$email = '';
$password = '';

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    require('validateLogin.php');
    validateEmail();
    validatePassword();

    //only if there have been no errors in the form, the entries are validated;
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        $usuario = $userQ->get($_POST["email"], $_POST["password"]);
        if ($usuario != null) {
            if (isset($_POST["remember"]) && $_POST["remember"]  == 'remember') {
                setcookie("loggedId", $usuario->getDni(), time() + 60 * 60 * 24 * 30, "/");
            }
            $_SESSION['uid'] = $usuario->getDni();
            session_write_close();
            header("Location: ../../views/task/tarea.php");
        } else {
            $_SESSION['error'] = $errorsMessages->getError("login:invalid");
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
?>