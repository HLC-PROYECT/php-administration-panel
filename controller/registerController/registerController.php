<?php

require '../../utils/errorsMessages.php';

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
    if (empty($errors)) {
        filterAllInputs();
        $result = array();

        if ($userQ->checkEmail($_POST["email"])) {
            session_start();
            $_SESSION['error'] = $errorsMessages->getError("email:repeat");
            session_write_close();
            header("Location: ../../views/auth/login.php");
        } else {
            if ($userQ->checkDni($_POST["dni"])) {
                session_start();
                $_SESSION['error'] = $errorsMessages->getError("dni:repeat");
                session_write_close();
                header("Location: ../../views/auth/login.php");
            }else{
                $usuario = $userQ->save($_POST["dni"], $_POST["email"],$_POST["nombre_usuario"], $_POST["password"],$_POST["nombre"],$_POST["f_alta"],$_POST["tipo"]);
                if ($_POST["remember"] == 'remember') {
                    setcookie("loggedId", $usuario->getDni(), time() + 60 * 60 * 24 * 30, "/");
                }
                session_start();
                $_SESSION['uid'] = $usuario->getDni();
                session_write_close();
                header("Location: ../../views/home/home.php");
            }
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
