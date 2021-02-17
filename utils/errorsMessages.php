<?php

namespace errorsMessages;


class errorsMessages
{
    public function getError(string $errorCode):string
    {
        return match ($errorCode) {
            "login:invalid" => "The user or the password were not valid",
            "email:invalid" => "Person email is not valid. Please enter a valid email",
            "email:repeat" => "The mail you tried to use is already in use. Please, use another one.",
            "dni:repeat" => "This DNI is already in use, just sign in!",
            "password:invalid" => "Password is not valid. Must have almost 8 characters",
            default => "Error not controlled",
        };
    }
}

?>