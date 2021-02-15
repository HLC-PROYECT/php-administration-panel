<?php

namespace User;

final class user
{

    private string $dni;
    private string $email;
    private string $password;

    public function __construct($dni, $email, $password)
    {
        $this->dni= $dni;
        $this->email = $email;
        $this->password = $password;
    }

    public function getDni():string
    {
        return $this->dni;
    }

    public function getEmail():string
    {
        return $this->email;
    }

    public function getPassword():string
    {
        return $this->password;
    }

}