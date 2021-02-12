<?php

function validateEmail()
{
    global $errors, $email,$errorsMessages;
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        //Check if the name only contains letters.
        if (!preg_match("/[-0-9a-zA-Z.+]+@[-0-9a-zA-Z.+]+.[a-zA-Z]{2,4}/", $email)) {
            $errors[] = $errorsMessages->getError("email:invalid");
        }
    }
}

function validatePassword()
{
    global $errors, $password,$errorsMessages;
    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
        //Check if the name only contains letters.
        if (strlen($password) < 8) {
            $errors[] = $errorsMessages->getError("password:invalid");
        }
    }
}


function filterAllInputs()
{
    global $password, $email;
    $email = filter($_POST['email']);
    $password = filter($_POST['password']);
}


//Applies a common filtering to all the inputs of the form
function filter($datos)
{
    $datos = trim($datos); // Delete All spaces before and after the data
    $datos = stripslashes($datos); // Delete backslashes \
    $datos = htmlspecialchars($datos); // Translate special characters in HTML entities  
    return $datos;
}


?>