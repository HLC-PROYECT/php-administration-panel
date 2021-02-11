<?php

require '../utils/getQuerys.php';

use QueryHelper\QueryHelper;

$query = new QueryHelper();

if (!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {
    try {
        $usuario = $query->getUserWithController($_POST["email"], $_POST["password"]);
        if ($_POST["remember"] == 'remember') {
            setcookie("loggedId", $usuario->getId(), time() + 60 * 60 * 24 * 30, "/");
        }
        header("Location: ../testClasses/logComplete.php?response=" . $usuario->getId());
    } catch (Exception $e) {
        echo $e;
    }
} else {
    echo "error";
}
?>
