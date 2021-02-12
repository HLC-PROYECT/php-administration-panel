<?php

namespace errorsMessages;


class errorsMessages
{
    public function getError(string $errorCode):string
    {
        return match ($errorCode) {
            "login:invalid" => "El usario o contraseña no son validos",
            "email:invalid" => "Person email is not valid. Please enter a valid email",
            "password:invalid" => "Password is not valid. Must have almost 8 character",
            "register:repeat" => "el correo que intento usar ya esta registrado",
            default => "Error no controlado",
        };
    }
}