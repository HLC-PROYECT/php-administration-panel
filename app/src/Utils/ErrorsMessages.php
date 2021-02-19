<?php

namespace HLC\AP\Utils;

final class ErrorsMessages
{
    public static function getError(string $errorCode): string
    {
        return match ($errorCode) {
            "login:invalid" => "The user or the password were not correct",
            "email:invalid" => "The email was not correct. Please enter a valid one",
            "email:repeat" => "The mail you entered is already in use. If its yours, sign in.",
            "dni:repeat" => "The DNI you entered is already in use. If its yours, sign in.",
            "password:invalid" => "The password you antered was not correct",
            default => "Error not controlled",
        };
    }
}
