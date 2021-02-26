<?php

namespace HLC\AP\Utils;

final class ErrorsMessages
{
    public static function getError(string $errorCode): string
    {
        return match ($errorCode) {
            "login:invalid" => "The user or the password were not valid",
            "email:invalid" => "Person email is not valid. Please enter a valid email",
            "email:repeat" => "The mail you tried to use is already in use. Please, use another one.",
            "dni:repeat" => "This DNI is already in use, just sign in!",
            "password:invalid" => "Password is not valid. Must have almost 8 characters",
            "date:lessActual" => "The end date cannot be smaller than the current one",
            "date:EndLessStart" => "The end date cannot be less than the start date",
            "generic:emptyFields" => "All fields have to be filled",
            default => "Error not controlled",
        };
    }
}