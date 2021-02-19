<?php
namespace HLC\AP\Controller\Logout;

setcookie("loggedId", null, -1, '/');
header("Location: ../../index.php");

