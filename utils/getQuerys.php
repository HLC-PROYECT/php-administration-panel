<?php

namespace QueryHelper;

require 'Medoo.php';
//require '../entities/user.php';
require_once __DIR__ . '/../entities/user.php';
use Medoo\Medoo;
use mysql_xdevapi\Exception;
use User\user;

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

    /**
     * @param array $usuario
     * Sera llamada por las clases internas para crear objetos usuarios
     * @return user
     */

    private function instanciteUser(array $usuario): user
    {
        return new user(intval($usuario["id"]), $usuario["email"], $usuario["password"]);
    }

    /**
     * @param string $email
     * @param string $password
     * Creado pensado en el login, donde nos devolvera el usuario instanciado si existe
     * @return user|null
     */
    private function getUser(string $email, string $password): ?user
    {
        $u = $this->database->select("usuario", "*", ["email" => $email, "password" => $password])[0];
        echo $u["id"];
        if ($u != null) {
            return $this->instanciteUser($u);
        } else {
            return null;
        }
    }

    /**
     * @param int $id
     * Te devuelve una instancia ya creada de usuario
     * @return user
     */
    public function getUserByid(int $id): ?user
    {
        return $this->instanciteUser($this->database->select("usuario", "*", ["id" => $id])[0]);
    }

    /**
     * @param string $email
     * @param string $password
     * funcion privada donde se inserta el usuario en la tabla
     * @return bool|\PDOStatement
     */
    private function createUser(string $email, string $password): bool|\PDOStatement
    {
        return $this->database->insert("usuario", ["email" => $email, "password" => $password]);
    }

    /**
     * @param string $email
     * @param string $password
     * llama a la funcion de createUser() y si el usuario no se ha podido crear lanza una excepcion
     * @return user
     */
    public function createUserWithController(string $email, string $password): user
    {
        $user = $this->createUser($email, $password);
        if (is_bool($user)) {
            throw new Exception("error al crear");
        } else {
            return $this->getUser($email, $password);
        }

    }

    public function checkExistUser(string $email): bool
    {
        return $this->database->has("usuario", ["email" => $email]);
    }

    public function getUserWithController(string $email, string $password): ?user
    {
        $user = $this->getUser($email, $password);
        if ($user != null) {
            return $user;
        } else {
            return null;
        }
    }


}
