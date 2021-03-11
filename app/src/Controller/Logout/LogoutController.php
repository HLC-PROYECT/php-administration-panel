<?php
namespace HLC\AP\Controller\Logout;

setcookie("loggedId", null, -1, '/');
unset($_SESSION['uid']);
header("Location: /");
