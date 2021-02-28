<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\TaskSubject\TaskSubject;
use HLC\AP\Domain\TaskSubject\TaskSubjectRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;

class PdoTaskSubjectRepository implements TaskSubjectRepositoryInterface
{
    private Medoo $database;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    private function instantiate(array $row): TaskSubject
    {
        $taskId = $row["codtarea"];
        $taskName = $row["nombretarea"];
        $taskDateStart = $row["f_inicio"];
        $taskDateEnd = $row["f_fin"];
        $status = $row["estado"];
        $description = $row["descrip"];

        $subjectId = $row["codasig"];
        $subjectName = $row["nombreasignatura"];
        $subjectNumHours = $row["n_horas"];
        $subjectDateEnd = $row["anyo_fin"];
        $courseId = $row["codcurso"];
        $identificationDocumentTeacher = $row["dniprofesor"];

        return TaskSubject::build(
            Task::build(
                $taskId,
                $taskName,
                $description,
                $taskDateStart,
                $taskDateEnd,
                $status
            ),
            Subject::build(
                $subjectId,
                $subjectName,
                $subjectNumHours,
                $subjectDateEnd,
                $courseId,
                $identificationDocumentTeacher
            )
        );
    }

    public function getTaskSubjectUsingDni(string $identificationDocument): array
    {

        $result = $this->database->select("tarea",
            [
                "[>]asignatura" => "codasig"
            ],
            "*",
            [
                "asignatura.dniprofesor" => $identificationDocument
            ]
        );

        $taskSubject = [];
        foreach ($result as $value) {
            array_push($taskSubject,
                $this->instantiate($value)
            );
        }

        return $taskSubject;
    }
}
