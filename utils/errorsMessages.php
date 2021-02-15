<?php

namespace errorsMessages;

class errorsMessages
{
    public function getError(string $errorCode):string
    {
        return match ($errorCode) {
            "login:invalid" => "The user or the password were not correct, please try again",
            "email:invalid" => "Person's email is not valid. Please enter a valid email.",
            "email:repeat" => "This mail is already in use. If its yours, try to login.",
            "password:invalid" => "Password is not valid. Must have almost 8 characters.",
            default => "Error not controlled.",
        };
    }
}