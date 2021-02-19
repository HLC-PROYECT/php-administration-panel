<?php

namespace HLC\AP\Repository;

use Medoo\Medoo;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;

final class PdoTaskRepository implements TaskRepositoryInterface
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = DatabaseConnection::getDatabaseInstance()->getMedooDatabase();
    }

    public function save(
        string $name,
        string $dateStart,
        string $dateEnd,
        string $status,
        string $description,
        int $subjectId
    ): bool {
        $r = $this->database->insert("tarea",
            [
                "nombretarea" => $name,
                "f_inicio" => $dateStart,
                "f_fin" => $dateEnd,
                "estado" => $status,
                "descrip" => $description,
                "codasig" => $subjectId
            ]
        );

        if ($r->errorCode() == '00000') {
            return true;
        } else {
            //TODO: ERROR: Añadir error al session
            return false;
        }
    }

    /** @return Task[] */
    public function get(): array
    {
        //TODO: Comprobar lo que esta devolviendo

        $task = array();
        $r = $this->database->select("tarea", "*");

        if (isset($r["codtarea"])) {
            $r[] = $r;
        }

        foreach ($r as $value) {
            $t = array(
                "codtarea" => $value["codtarea"],
                "nombretarea" => $value["nombretarea"],
                "f_inicio" => $value["f_inicio"],
                "f_fin" => $value["f_fin"],
                "estado" => $value["estado"],
                "descrip" => $value["descrip"]
            );
            array_push($tasks, $this->instantiate($t));
        }
        return $task;
    }

    public function deleteById(int $taskId): bool
    {
        $r = $this->database->delete("tarea", ["codtarea" => $taskId]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getById(int $taskId): ?Task
    {
        return $this->instantiate($this->database->select("tarea", "*", ["codtarea" => $taskId]));
    }

    private function instantiate(array $task): Task
    {
        return Task::build(
            intval($task["codtarea"]),
            $task["nombretarea"],
            $task["descrip"],
            $task["f_inicio"],
            $task["f_fin"],
            $task["estado"]
        );
    }
}
