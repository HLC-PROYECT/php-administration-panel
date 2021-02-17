<?php


namespace Task;

use Medoo\Medoo;

class PdoTaskRepository implements TaskDataSource
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'heroku_1e6e284b61da958',
            'server' => 'eu-cdbr-west-03.cleardb.net',
            'username' => 'bca69c49b83a98',
            'password' => '52f0c250',
            'charset' => 'utf8'
        ]);
    }

    public function save(int $codTask, string $taskName, string $initialDate, string $endDate, string $state, string $des, int $codSubject): bool
    {
        $r = $this->database->insert("tarea", ["codtarea" => $codTask, "nombretarea" => $taskName, "f_inicio" => $initialDate,
            "f_fin" => $endDate, "estado" => $state, "descrip" => $des, "codasig" => $codSubject]);
        if ($r->errorCode() == '00000') {
            return true;
        } else {
            //TODO(): ERROR: Añadir error al session
            return false;
        }
    }

    public function get(): Task|array
    {
        $task = $this->database->select("tarea","*");
        if (is_array($task)){
        }
    }

    public function deleteById(int $taskId): bool
    {
        $r = $this->database->delete("tarea", ["codtarea" => $taskId]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getById(int $taskId): Task
    {
        return $this->instantiate($this->database->select("tarea", "*", ["codtarea" => $taskId]));
    }

    public function instantiate(array $task): Task
    {
        return new Task(intval($task["codtarea"]), $task["nombretarea"], $task["descrip"], $task["f_inicio"], $task["f_fin"], $task["estado"]);
    }
}