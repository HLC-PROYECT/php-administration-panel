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
    $response = $database->select("usuario", "*", ["email" => $_POST["email"], "password" => $_POST["password"]]);
    if ($response != null) {
        $r = $response[0];
        header("Location: ../testClasses/logComplete.php?response=".$r["id"]);
    } else {
        $error = true;
    }

} else {
    $error = true;
}
?>
