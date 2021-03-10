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

    public function deleteStudent(string $identificationDocument):bool;

    public function getByDni(string $userDni): ?User;

    public function checkDni(string $dni): bool;

    public function checkEmail(string $email): bool;

    /** @return User[] */
    public function getTeachers(): array;

    public function savePupil($id, $birthDate, $courseID): bool;

    public function saveTeacher($id): bool;

    public function getStudents(string $teacherID, string $order): array;
}