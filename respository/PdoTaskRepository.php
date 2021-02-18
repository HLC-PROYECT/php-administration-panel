<?php


namespace Task;

use Medoo\Medoo;

class PdoTaskRepository implements taskDataSource
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

    public function save( string $taskName, string $initialDate, string $endDate, string $state, string $des, int $codSubject): bool
    {
        $r = $this->database->insert("tarea", [ "nombretarea" => $taskName, "f_inicio" => $initialDate,
            "f_fin" => $endDate, "estado" => $state, "descrip" => $des, "codasig" => $codSubject]);
        if ($r->errorCode() == '00000') {
            return true;
        } else {
            //TODO(): ERROR: Añadir error al session
            return false;
        }
    }

    public function get(): task|array|null
    {
        $r = $this->database->select("tarea", "*");
        if (is_array($r)) {
            $task = array();
            foreach ($r as $key => $value) {
                $t = array("codtarea" => $value["codtarea"], "nombretarea" => $value["nombretarea"], "f_inicio" => $value["f_inicio"], "f_fin" => $value["f_fin"], "estado" => $value["estado"], "descrip" => $value["descrip"]);
                array_push($tasks, $this->instantiate($t));
            }
            return $task;

        } elseif ($r == null) {
            return null;
        } else {
            echo "<script>console.log('Debug Objects: " . print_r($r) . "' );</script>";
            $t = array("codtarea" => $r["codtarea"], "nombretarea" => $r["nombretarea"], "f_inicio" => $r["f_inicio"], "f_fin" => $r["f_fin"], "estado" => $r["estado"], "descrip" => $r["descrip"]);
            return $this->instantiate($t);
        }
    }

    public function deleteById(int $taskId): bool
    {
        $r = $this->database->delete("tarea", ["codtarea" => $taskId]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getById(int $taskId): ?task
    {
        return $this->instantiate($this->database->select("tarea", "*", ["codtarea" => $taskId]));
    }

    public function instantiate(array $task): task
    {
        return new Task(intval($task["codtarea"]), $task["nombretarea"], $task["descrip"], $task["f_inicio"], $task["f_fin"], $task["estado"]);
    }
}