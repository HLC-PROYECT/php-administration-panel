<?php

namespace User;
use Medoo\Medoo;

class PdoUserRepository implements UserRepositoryInterface
{
    private Medoo $database;

    /**
     * PdoUserRepository constructor.
     */
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


    public function delete(string $userDni): bool
    {
        $r = $this->database->delete("usuario", ["dni" => $userDni]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getByDni(string $userDni): User
    {
        return $this->instantiate($this->database->select("usuario", "*", ["dni" => $userDni])[0]);
    }

     public function instantiate(array $user): User
    {
        return new user($user["dni"], $user["email"], $user["password"],
            $user["nomb_usuario"], $user["nombre"], $user["f_alta"], $user["tipo"]);
    }

    public function checkDni(string $dni): bool
    {
        return $this->database->has("usuario", ["dni" => $dni]);
    }

    public function checkEmail(string $email): bool
    {
        return $this->database->has("usuario", ["email" => $email]);
    }

    public function get(string $email, string $password): ?User
    {
        $user = $this->database->select("usuario", "*", ["email" => $email, "password" => $password]);

        if ($user != null) {
            return $this->instantiate($user[0]);
        }else{
            //TODO(): ERROR: añadir error de usuario no encontrado
            return null;
        }
    }

    public function save(string $dni, string $email, string $nombre_usuario, string $password, string $nombre, string $f_alta, string $tipo): bool
    {
        $r=  $this->database->insert("usuario", ["dni" => $dni, "email" => $email, "nomb_usuario" => $nombre_usuario,
            "password" => $password, "nombre" => $nombre, "f_alta" => $f_alta, "tipo" => $tipo]);
        if ($r->errorCode() =='00000'){
            return true;
        }else{
            //TODO(): ERROR: Añadir error al session
            return false;
        }
    }
}