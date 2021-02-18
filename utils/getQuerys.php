<?php

namespace QueryHelper;

require 'Medoo.php';/*
require_once __DIR__ . '/../domain/user/user.php';*/

use Medoo\Medoo;
use mysql_xdevapi\Exception;
use Subject\subject;
use Task\task;
use TaskSubject\taskSubject;

class QueryHelper
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

}
