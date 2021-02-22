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


    public function save(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool
    {
        $response = $this->database->insert("curso",
            [
                "codCurso" => $courseId,
                "centroed" => $educationCenter,
                "año_ini" => $yearStart,
                "año_fin" => $yearEnd
            ]);

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
        $QUERY = "SELECT distinct c.* from curso c join asignatura a on c.codcurso = a.codcurso join profesor p on p.dni = a.dniprofesor where dni = '$teacherID'";
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

    public function getTeacherCourses(): array
    {
        $result = $this->database->select("curso", "*");

        $tasksubject = array();
        foreach ($result as $value) {
            $course = array(
                "codcurso" => $value["codcurso"],
                "centroed" => $value["centroed"],
                "año_ini" => $value["año_ini"],
                "año_fin" => $value["año_fin"],
                "descrip" => $value["descrip"]
            );
            $tasksubject[] = $this->instantiateCourse($course);
        }
        return $tasksubject;
    }
}
