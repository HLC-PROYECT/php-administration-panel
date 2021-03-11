<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;

class PdoCourseRepository implements CourseRepositoryInterface
{
    private Medoo $database;

    public function __construct(private DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    public function insert(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool
    {

        $response = $this->database->insert('curso',
            [
                'codcurso' => $courseId,
                'centroed' => $educationCenter,
                'a_inicio' => $yearStart,
                'a_fin' => $yearEnd,
                'descrip' => $description
            ]
        );

        return $response->errorCode() == '00000';
    }

    public function delete(int $courseId): bool
    {
        $response = $this->database->delete("curso", ["codCurso" => $courseId]);
        return $response->errorCode() == '00000';
    }

    public function getById(int $courseId): Course
    {
        return $this->instantiate($this->database->select("curso", "*", ["codCurso" => $courseId])[0]);
    }

    public function getCoursesById($identificationDocument, $order): array
    {
        $result = $this->database->select("curso",
            [
                "[>]curso_profesor" => "codcurso"
            ],
            "*",
            [
                "curso_profesor.dniprofesor" => $identificationDocument,
                'ORDER' => $order
            ]
        );

        $courses = [];
        foreach ($result as $value) {
            array_push($courses, $this->instantiate($value));
        }

        return $courses;
    }

    public function get(): array
    {
        $result = $this->database->select("curso", "*");

        $courses = [];
        foreach ($result as $value) {
            array_push($courses, $this->instantiate($value));
        }

        return $courses;
    }

    private function instantiate(array $course): Course
    {
        return Course::build(
            $course["codcurso"],
            $course["centroed"],
            $course["a_inicio"] ?? 0,
            $course["a_fin"] ?? 0,
            $course["descrip"]
        );
    }

    public function getLastCourseInserted(): int
    {
        $result = $this->database->query("SELECT codcurso from curso order by codcurso desc limit 1");
        $codcurso = 0;
        foreach ($result as $value) {
            $codcurso = $value["codcurso"];
        }

        return $codcurso;
    }

    public function checkCourseId($courseId): bool
    {
        return $this->database->has("curso", ["codcurso" => $courseId]);
    }

    public function save(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): string
    {
        if ($courseId === 0) {
            $this->insert($courseId, $educationCenter, $yearStart, $yearEnd, $description);
            return 'insert';
        } else {
            $this->update($courseId, $educationCenter, $yearStart, $yearEnd, $description);
            return 'update';
        }
    }

    public function update(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool
    {
        $response = $this->database->update(
            'curso',
            [
                'centroed' => $educationCenter,
                'a_inicio' => $yearStart,
                'a_fin' => $yearEnd,
                'descrip' => $description

            ],
            ['codcurso' => $courseId]
        );

        return $response->errorCode() == '00000';
    }

    public function getPupilCourse($identificationDocument): array
    {
        $result = $this->database->select(
            'curso',
            ["[><]alumno" => "codcurso"],
            [
                "curso.codcurso",
                "centroed",
                "a_inicio",
                "a_fin",
                "descrip"
            ],
            ["dni" => $identificationDocument]
        );

        $courses = [];
        foreach ($result as $value) {
            array_push($courses, $this->instantiate($value));
        }

        return $courses;
    }

    public function getNotJoinedCourse($identificationDocument): array
    {
        $result = $this->database->query("Select distinct C.* from curso C
                                                     where C.codCurso not in (Select codCurso from curso_profesor where dniProfesor = '$identificationDocument')");

        $courses = [];
        foreach ($result as $value) {
            array_push($courses, $this->instantiate($value));
        }

        return $courses;
    }
}
