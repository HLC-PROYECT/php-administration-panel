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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    require('validateRegister.php');
    validateEmail();
    validatePassword();

    //only if there have been no errors in the form, the entries are validated;
    session_start();
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        if ($userQ->checkEmail($_POST["email"])) {
            $_SESSION['error'] = $errorsMessages->getError("email:repeat");
            session_write_close();
            header("Location: ../../views/auth/login.php");
        } else {
            if ($userQ->checkDni($_POST["dni"])) {
                $_SESSION['error'] = $errorsMessages->getError("dni:repeat");
                session_write_close();
                header("Location: ../../views/auth/login.php");
            } else {
                $fecha = new DateTime();
                $r = $userQ->save($_POST["dni"], $_POST["email"], $_POST["alias"], $_POST["password"], $_POST["name"], date("Y-m-d", $fecha->getTimestamp()), $_POST["tipo"]);
                if ($r) {
                    $usuario = $userQ->getByDni($_POST["dni"]);
                    if (isset($_POST["remember"]) && $_POST["remember"]  == 'remember') {
                        setcookie("loggedId", $usuario->getDni(), time() + 60 * 60 * 24 * 30, "/");
                    }
                    $_SESSION['uid'] = $usuario->getDni();
                    session_write_close();
                    header("Location: ../../views/task/tarea.php");
                }
            }
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