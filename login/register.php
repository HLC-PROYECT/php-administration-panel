<?php
require '../utils/Medoo.php';

use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'task_manager',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);
if (!empty(trim($_POST["email"])) && !empty(trim($_POST["password"]))) {

    if ($database->has("usuario", ["email" => $_POST["email"]])) {
        echo "Ya hay un usuario con este correo";
    } else {
        $query = $database->insert("usuario", ["email" => $_POST["email"], "password" => $_POST["password"]]);
        $result = $query->errorCode();
        if ($result == 00000) {
            $response = $database->select("usuario", "*", ["email" => $_POST["email"]]);
            if ($_POST["remember"] == 'remember') {
                setcookie("loggedId", $response[0]["id"], time() + 60 * 60 * 24 * 30, "/");
            }
            header("Location: ../testClasses/logComplete.php?response=" . $response[0]["id"]);
        }
        echo $result;
    }
}