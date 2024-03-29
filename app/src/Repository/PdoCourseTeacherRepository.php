<?php

namespace HLC\AP\Repository;

use Medoo\Medoo;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;

final class PdoCourseTeacherRepository implements CourseTeacherRepositoryInterface
{
    private Medoo $database;

    public function __construct(private DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }


    public function insert(int $courseID, string $identificationDocument)
    {
        $this->database->insert('curso_profesor',
            [
                "codcurso" => $courseID,
                "dniprofesor" => $identificationDocument
            ]);
    }

    public function deleteByCourse(int $courseID)
    {
        $this->database->delete(
            'curso_profesor',
            ["codcurso" => $courseID]
        );
    }
}