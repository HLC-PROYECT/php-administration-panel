<?php
require_once __DIR__ . '/../vendor/autoload.php';
if (isset($_COOKIE["loggedId"])) {
    setcookie("uid", $_COOKIE["loggedId"], time() + 60, "/");
    header("Location: views/home/home.php");
} else {
    header("Location: views/auth/login.php");
}