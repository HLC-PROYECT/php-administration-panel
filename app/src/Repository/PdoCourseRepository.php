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
        $response = $this->database->query("INSERT INTO curso value ($courseId,'$educationCenter',$yearStart,$yearEnd,'$description');");

        return $response->errorCode() == '00000';
    }

    public function delete(int $courseId): bool
    {
        $response = $this->database->delete("curso", ["codCurso" => $courseId]);
        return $response->errorCode() == '00000';
    }

    public function getById(int $courseId): Course
    {
        return $this->instantiateCourse($this->database->select("curso", "*", ["codCurso" => $courseId])[0]);
    }

    public function getAllCourses($teacherID): array
    {
        $QUERY = "SELECT  * from curso where codcurso in (select codcurso from curso_profesor where dniProfesor = '$teacherID')";
        $result = $this->database->query($QUERY);
        $courses = array();

        foreach ($result as $value) {
            $course = array(
                "codcurso" => $value["codcurso"],
                "centroed" => $value["centroed"],
                "año_ini" => $value["año_ini"],
                "año_fin" => $value["año_fin"],
                "descrip" => $value["descrip"]
            );
            array_push($courses, $this->instantiateCourse($course));
        }
        return $courses;
    }

    private function instantiateCourse(array $course): Course
    {
        return Course::build($course["codcurso"], $course["centroed"], $course["año_ini"], $course["año_fin"], $course["descrip"]);
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
}
