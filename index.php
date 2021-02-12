<?php
if (isset($_COOKIE["loggedId"])) {
    setcookie("uid", $_COOKIE["loggedId"], time() + 60, "/");
    header("Location: testClasses/logComplete.php");
} else {
    header("Location: views/auth/login.php");
}
