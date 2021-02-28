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
            "educationCenter:invalid" => "Education center not valid",
            "yearEmpty:invalid" => "Year fields is empty",
            "year:invalid" => "Year is invalid, must be between 2000 and 2050",
            "yearStart:invalid" => "Year start cant not be greater than the end",
            "20001" => "Problem occurred when trying to create a task",
            default => "Error not controlled",
        };
    }
}
