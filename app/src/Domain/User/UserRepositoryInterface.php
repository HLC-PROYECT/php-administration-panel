<?php

namespace HLC\AP\Domain\User;

interface UserRepositoryInterface
{
    public function save(
        string $dni,
        string $email,
        string $nick,
        string $password,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $type
    ): bool;

    public function get(string $email, string $password): ?User;

    public function delete(string $userDni): bool;

    public function getByDni(string $userDni): ?User;

    public function checkDni(string $dni): bool;

    public function checkEmail(string $email): bool;
}