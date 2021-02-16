<?php

namespace User;

interface UserRepositoryInterface
{
    public function save(string $dni,string $email,string $nombre_usuario, string $password, string $nombre, string $f_alta,string $tipo):bool;
    public function get(string $email, string $password): ?User;
    public function delete(string $userDni):bool;
    public function getByDni(string $userDni):User;
    public function instantiate(array $user):User;
    public function checkDni(string $dni):bool;
    public function checkEmail(string $email):bool;
}