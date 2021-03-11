<?php

namespace HLC\AP\Repository;

use Exception;
use Medoo\Medoo;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;

final class PdoTaskRepository implements TaskRepositoryInterface
{
    private Medoo $database;

    public function __construct(private DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    public function save(Task $task): Task
    {
        if ($task->getTaskId() == 0) {
            $r = $this->database->insert("tarea",
                [
                    "nombretarea" => $task->getName(),
                    "f_inicio" => $task->getDateStart(),
                    "f_fin" => $task->getDateEnd(),
                    "estado" => $task->getStatus(),
                    "descrip" => $task->getDescription(),
                    "codasig" => $task->getSubjectId()
                ]
            );

            $codcurso = $this->database->select("asignatura", "codcurso", ["codasig" => $task->getSubjectId()])[0];

            $taskId = $this->database->select(
                "tarea",
                "codtarea",
                ["ORDER" =>
                    [
                        "codtarea" => "DESC"
                    ],
                    "LIMIT" => 1
                ]
            )[0];

            $this->database->query(
                "insert into tarea_alumno (dni, codtarea)
                             select dni, $taskId
                                from alumno
                                    where codcurso = $codcurso"
            );

        } else {
            $r = $this->database->update("tarea",
                [
                    "nombretarea" => $task->getName(),
                    "f_inicio" => $task->getDateStart(),
                    "f_fin" => $task->getDateEnd(),
                    "estado" => $task->getStatus(),
                    "descrip" => $task->getDescription(),
                    "codasig" => $task->getSubjectId()
                ],
                ["codtarea" => $task->getTaskId()]
            );
        }

        if ($r->errorCode() != '00000') {
            throw new Exception($r->errorInfo(), 20001);
        }

        return $task;
    }

    public function get($isTeacher = true): array
    {
        $task = array();

        if ($isTeacher) $response = $this->database->select("tarea", "*");
        //TODO: Alumno
        else $response = $this->database->query(
            "select t.*
                        from tarea t 
                            join tarea_alumno ta on t.codtarea = ta.codtarea 
                                where ta.dni = '12345678C'");

        foreach ($response as $row) {
            array_push($tasks, $this->instantiate($row));
        }

        return $task;
    }

    public
    function deleteById(int $taskId): bool
    {
        $response2 = $this->database->delete("tarea_alumno", ["codtarea" => $taskId]);
        $response = $this->database->delete("tarea", ["codtarea" => $taskId]);
        return $response->errorCode() === '00000' && $response2 === '00000';
    }

    public
    function getById(int $taskId): Task
    {
        $response = $this->database->select("tarea", "*", ["codtarea" => $taskId]);

        if (true === empty($response)) {
            throw new Exception('task not found');
        }

        return $this->instantiate($response[0]);
    }

    private
    function instantiate(array $task): Task
    {
        return Task::build(
            intval($task["codtarea"]),
            $task["nombretarea"],
            $task["descrip"],
            $task["f_inicio"],
            $task["f_fin"],
            $task["estado"],
            $task["codasig"]
        );
    }

    public function send(string $dni, string $taskId): bool
    {
        $response = $this->database->update("tarea_alumno",
            ["completada" => true],
            [
                "dni" => $dni,
                "codtarea" => $taskId
            ]
        );
        return $response->errorCode() === '00000';
    }

    public function updateTeacherCompleted(Task $task): void
    {
       $this->database->update("tarea",
            ["estado" => "completada"],
            [
                "codtarea" => $task->getTaskId()
            ]
        );
    }
}
