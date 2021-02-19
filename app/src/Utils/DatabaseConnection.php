<?php

namespace HLC\AP\Utils;

use Medoo\Medoo;

final class DatabaseConnection
{
    private static DatabaseConnection|null $instance = null;
    private Medoo $database;
    private string $databaseName = 'instituto';
    private string $server = 'db';
    private string $userName = 'root';
    private string $password = 'root';

    private function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => $this->databaseName,
            'server' => $this->server,
            'username' => $this->userName,
            'password' =>  $this->password,
            'charset' => 'utf8'
        ]);
    }

    public static function getDatabaseInstance(): DatabaseConnection
    {
        if (self::$instance == null) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    public function getMedooDatabase(): Medoo
    {
        return $this->database;
    }
}
