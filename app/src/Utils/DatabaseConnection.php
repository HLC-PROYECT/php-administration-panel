<?php

namespace HLC\AP\Utils;

use Medoo\Medoo;

final class DatabaseConnection
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'heroku_1e6e284b61da958',
            'server' => 'eu-cdbr-west-03.cleardb.net',
            'username' => 'bca69c49b83a98',
            'password' => '52f0c250',
            'charset' => 'utf8'
        ]);
    }

    public function getMedooDatabase(): Medoo
    {
        return $this->database;
    }
}
