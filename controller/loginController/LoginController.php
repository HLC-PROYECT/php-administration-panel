<?php

require '../../utils/getQuerys.php';
require '../../utils/errorsMessages.php';

use errorsMessages\errorsMessages;
use QueryHelper\QueryHelper;

$errorsMessages = new errorsMessages();

$query = new QueryHelper();
$errors = array();
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    require('validateLogin.php');
    validateEmail();
    validatePassword();

    //only if there have been no errors in the form, the entries are validated;
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        $usuario = $query->getUserWithController($_POST["email"], $_POST["password"]);
        if ($usuario != null) {
            if ($_POST["remember"] == 'remember') {
                setcookie("loggedId", $usuario->getId(), time() + 60 * 60 * 24 * 30, "/");
            }
            session_start();
            $_SESSION['uid'] = $usuario->getId();
            session_write_close();
            header("Location: ../../views/home/home.php");
        } else {
            session_start();
            $_SESSION['error'] = $errorsMessages->getError("login:invalid");
            session_write_close();
            header('location: ../../views/auth/login.php');
        }

    } else {
        session_start();
        $_SESSION['error'] = $errors;

        session_write_close();
        /*
            Inicio una sesión para poder enviar mediante el método POST el array
            que contiene los errores cometidos por el usuario en el formulario.
            Y así poder navegar hacia la página de errores sin exponer los datos por la url.
        */

        header('location: ../../views/auth/login.php');
    }

} else {
    header('location: ../../views/auth/login.php');

}
?>