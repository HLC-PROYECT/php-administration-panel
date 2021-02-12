<?php

function validateEmail(){
    global $errors, $email;
    if (!empty($_POST["email"])) {
        $email = $_POST["email"];
        //Check if the name only contains letters.
        if (!preg_match("^[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,6}$", $email)) {
            $errors[] = "Person email is not valid. Please enter a valid email <br>";
        }
    }
}

function validatePassword(){
    global $errors,$password;
    if (!empty($_POST["password"])) {
        $password = $_POST["password"];
        //Check if the name only contains letters.
        if (strlen($password) < 8) {
            $errors[] = "Password is not valid. Only must have numbers not other character. <br>";
        }
    }
}



function filterAllInputs(){
    global $password,$email;
    $email = filter($_POST['email']);
    $password = filter($_POST['password']);
}





//Applies a common filtering to all the inputs of the form
function filter($datos){
    $datos = trim($datos); // Delete All spaces before and after the data
    $datos = stripslashes($datos); // Delete backslashes \
    $datos = htmlspecialchars($datos); // Translate special characters in HTML entities  
    return $datos;
}


?>