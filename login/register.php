<?php

require '../utils/getQuerys.php';

use QueryHelper\QueryHelper;

$query = new QueryHelper();

if (!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {


    if ($query->checkExistUser($_POST["email"])) {
        header("Location: login.html?error=1");
    } else {
        $usuario = $query->createUserWithController($_POST["email"], $_POST["password"]);
        if ($_POST["remember"] == 'remember') {
            setcookie("loggedId", $usuario->getId(), time() + 60 * 60 * 24 * 30, "/");
        }
        setcookie("uid", $usuario->getId(), time() + 60, "/");
        header("Location: ../testClasses/logComplete.php");
    }
}