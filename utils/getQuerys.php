<?php

namespace QueryHelper;

require 'Medoo.php';

use Medoo\Medoo;

class QueryHelper
{
    private $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'task_manager',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);
    }

    public function getUserByid(int $id)
    {
        return $this->database->select("usuario", "*", ["id" => $id]);
    }
}
