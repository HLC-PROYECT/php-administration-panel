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
            "identificationDocument:repeat" => "This DNI is already in use, just sign in!",
            "password:invalid" => "Password is not valid. Must have almost 8 characters",
            "date:lessActual" => "The end date cannot be smaller than the current one",
            "date:EndLessStart" => "The end date cannot be less than the start date",
            "generic:emptyFields" => "All fields have to be filled",
            "educationCenter:invalid" => "Education center not valid",
            "yearEmpty:invalid" => "Year fields is empty",
            "year:invalid" => "Year is invalid, must be between 2000 and 2050",
            "yearStart:invalid" => "Year start cant not be greater than the end",
            "type:invalid" => "Type of user is not valid, please select a correct option",
            "identificationDocument:invalid" => "Identification document is invalid.",
            "userName:invalid" => "User name is invalid, must be almost 4 characters long",
            "nickName:invalid" => "Nick name is invalid, must be almost 4 characters long",
            "courseID:invalid" => "Course id introduced is not valid. Must be a number",
            "courseID:notfound" => "Course id introduced not found, please check your ID",
            "date:invalid" => "Date invalid, must be greater than or equal to 1900 or less than actual",
            "20001" => "Problem occurred when trying to create a task",
            default => "Error not controlled",
        };
    }
}
