<?php
if (isset($_COOKIE["loggedId"])) {
    header("Location: testClasses/logComplete.php?response=" . $_COOKIE["loggedId"]);
} else {
    header("Location: login/login.html");
}
