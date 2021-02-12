<?php

namespace errorsMessages;


class errorsMessages
{
    public function getError(string $errorCode):string
    {
        return match ($errorCode) {
            "login:invalid" => "El usario o contraseña no son validos",
            "email:invalid" => "Person email is not valid. Please enter a valid email",
            "email:repeat" => "el correo que intentó usar ya esta registrado, Inicie sesion",
            "password:invalid" => "Password is not valid. Must have almost 8 character",
            default => "Error no controlado",
        };
    }
}