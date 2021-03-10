<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Student\Student;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;

final class PdoUserRepository implements UserRepositoryInterface
{
    private Medoo $database;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    public function delete(string $userDni): bool
    {
        $r = $this->database->delete("usuario", ["dni" => $userDni]);
        return $r->errorCode() == '00000';
    }

    public function getByDni(string $userDni): User
    {
        return $this->build($this->database->select("usuario", "*", ["dni" => $userDni])[0]);
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

        if (null == $user) {
            //TODO(): ERROR: añadir error de usuario no encontrado
            return null;
        }

        return $this->build($user[0]);
    }

    public function save(
        string $dni,
        string $email,
        string $nick,
        string $password,
        string $name,
        string $dateStart,
        string $dateEnd,
        string $type
    ): bool
    {
        $response = $this->database->insert(
            "usuario",
            [
                "dni" => $dni,
                "email" => $email,
                "nomb_usuario" => $nick,
                "password" => $password,
                "nombre" => $name,
                "f_alta" => $dateStart,
                "tipo" => $type
            ]
        );

        return $response->errorCode() != '00000';
    }

    public function savePupil($id, $birthDate, $courseID): bool
    {
        $response = $this->database->insert('alumno',
            [
                'dni' => $id,
                'fnac' => $birthDate,
                'codcurso' => $courseID
            ]
        );

        return $response->errorCode() != '00000';
    }

    public function saveTeacher($id): bool
    {
        $response = $this->database->insert('profesor',
            [
                'dni' => $id,
            ]
        );

        return $response->errorCode() != '00000';
    }

    public function getTeachers(): array
    {
        $responseTeacher = $this->database->select("usuario", "*", ["tipo" => "P"]);
        $teachers = [];

        foreach ($responseTeacher as $row) {
            array_push($teachers, $this->build($row));
        }

        return $teachers;
    }

    private function build(array $user): User
    {
        return User::build(
            $user["dni"],
            $user["email"],
            $user["password"],
            $user["nomb_usuario"] ?? $user["nombre"],
            $user["nombre"],
            $user["f_alta"],
            "", // $user["f_baja"],
            "", // $user["f_modificacion"],
            $user["tipo"]
        );
    }


    private function buildStudent(array $student): Student
    {
        return Student::buildStudent(
            $student["dni"],
            $student["email"],
            $student["password"],
            $student["nomb_usuario"] ?? $student["nombre"],
            $student["nombre"],
            $student["f_alta"],
            "",
            "",
            $student["tipo"],
            $student["fnac"],
            $student["codcurso"]
        );
    }

    public function getStudents(string $teacherID, string $order): array
    {
        $response = $this->database->select(
            "usuario",
            [
                "[><]alumno" => "dni",
                "[><]curso_profesor" => "codcurso"
            ],
            [
                "usuario.dni",
                "usuario.email",
                "usuario.nombre",
                "usuario.password",
                "usuario.nomb_usuario",
                "usuario.tipo",
                "usuario.f_alta",
                "alumno.codcurso",
                "alumno.fnac"
            ],
            [
                "usuario.tipo" => 'A',
                "curso_profesor.dniprofesor" => $teacherID,
                'ORDER' => $order
            ]
        );
        $students = [];
        foreach ($response as $student) {
            array_push($students, $this->buildStudent($student));
        }

        return $students;
    }

    public function deleteStudent(string $identificationDocument): bool
    {
        $this->database->delete('alumno', ["dni" => $identificationDocument,]);
    }
}

