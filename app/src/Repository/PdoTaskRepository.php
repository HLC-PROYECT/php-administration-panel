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

    public function get(): array
    {
        $task = array();
        $response = $this->database->select("tarea", "*");

        foreach ($response as $row) {
            array_push($tasks, $this->instantiate($row));
        }

        return $task;
    }

    public function deleteById(int $taskId): bool
    {
        $response = $this->database->delete("tarea", ["codtarea" => $taskId]);
        return $response->errorCode() === '00000';
    }

    public function getById(int $taskId): Task
    {
        $response = $this->database->select("tarea", "*", ["codtarea" => $taskId]);

        if (true === empty($response)) {
            throw new Exception('task not found');
        }

        return $this->instantiate($response[0]);
    }

    private function instantiate(array $task): Task
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
}
