<?php
require '../../utils/errorsMessages.php';
require '../../utils/Medoo.php';
require '../../domain/task/taskDataSource.php';
require '../../respository/PdoTaskRepository.php';

use errorsMessages\errorsMessages;
use Task\PdoTaskRepository;

$errorsMessages = new errorsMessages();
$taskRepo = new PdoTaskRepository();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    $fallo = false;
    session_start();
    if (empty($errors)) {
        /*filterAllInputs();*/
        $result = array();
        $ffin = strtotime($_POST['ffin']);
        $fstat = strtotime($_POST['finicio']);
        $fecha = new DateTime();
        $f = $fecha->getTimestamp();
        if (empty(trim($_POST["name"])) || empty(trim($_POST['desc']))) {
            $_SESSION['error'] = $errorsMessages->getError("generic:emptyFields");
            $fallo = true;
        } else if ($ffin < $f) {
            $_SESSION['error'] = $errorsMessages->getError("date:lessActual");
            $fallo = true;
        } elseif ($ffin < $ffin) {
            $_SESSION['error'] = $errorsMessages->getError("date:EndLessStart");
            $fallo = true;
        }
        if ($fallo) {
            session_write_close();
            header("Location: ../../views/task/tarea.php");
        } else {
            $res = $taskRepo->save($_POST['name'], date("Y-m-d", strtotime($_POST['finicio'])), date("Y-m-d", strtotime($_POST['ffin'])), "pendiente", $_POST['desc'], intval($_POST['asigs']));
            if ($res) {
                session_write_close();
                header("Location: ../../views/task/tarea.php");
            } else {
                //TODO: ERROR: Nuevo mensaje
                $_SESSION['error'] = $errorsMessages->getError("email:repeat");
                session_write_close();
            }
        }

    } else {
        $_SESSION['error'] = $errors;
        session_write_close();
        header('location: ../../views/task/tarea.php');
    }

} else {
    header('location: ../../views/task/tarea.php');
}