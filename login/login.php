<?php

require '../utils/getQuerys.php';

use QueryHelper\QueryHelper;

$query = new QueryHelper();
session_start();
if (!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {
    $usuario = $query->getUserWithController($_POST["email"], $_POST["password"]);
    if($usuario != null){
        if ($_POST["remember"] == 'remember') {
            setcookie("loggedId", $usuario->getId(), time() + 60 * 60 * 24 * 30, "/");
        }
        $_SESSION['uid'] = $usuario->getId();
        session_write_close();
        //setcookie("uid", $usuario->getId(), time() + 60, "/");
        header("Location: ../testClasses/logComplete.php" );
    }
    else{
        header("Location: login.html?error=2");
    }
} else {
    echo "error";
}

?>
