<?php

namespace QueryHelper;

require 'Medoo.php';/*
require_once __DIR__ . '/../domain/user/user.php';*/

use Medoo\Medoo;
use mysql_xdevapi\Exception;
use Subject\subject;
use Task\task;
use TaskSubject\taskSubject;

class QueryHelper
{
    private Medoo $database;

    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'instituto',
            'server' => 'db',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]);
    }
    private function instanciateTask(array $task): task
    {
        return new task(intval($task["codtarea"]), $task["nombretarea"], $task["descrip"], $task["f_inicio"], $task["f_fin"], $task["estado"]);
    }
    private function instanciateCourse(array $course): task
    {
        //TODO():Instaciar curso
        //return new task(intval($task["codtarea"]), $task["nombretarea"], $task["descrip"], $task["f_inicio"], $task["f_fin"], $task["estado"]);
    }

    private function instanciateSubect(array $subject): subject
    {
        return new subject(intval($subject["codasig"]), $subject["nombreasignatura"], intval($subject["n_horas"]), intval($subject["año_fin"]), intval($subject["codcurso"]), $subject["dniprofesor"]);
    }

    private function instanciateTaskSubject(task $task, subject $subject): taskSubject
    {
        return new taskSubject($task, $subject);
    }
    public function getTaskSubjectUsingDni(string $dni): taskSubject|array
    {
        $result = $this->database->query("select * from tarea t left join asignatura a on t.codasig = a.codasig where dniprofesor = '12345678A'")->fetchAll();
        if (is_array($result)) {
            $tasksubject = array();
            foreach ($result as $key => $value) {
                $task = array("codtarea" => $value["codtarea"], "nombretarea" => $value["nombretarea"], "f_inicio" => $value["f_inicio"], "f_fin" => $value["f_fin"], "estado" => $value["estado"], "descrip" => $value["descrip"]);
                $subject = array("codasig" => $value["codasig"], "nombreasignatura" => $value["nombreasignatura"], "n_horas" => $value["n_horas"], "año_fin" => $value["año_fin"], "codcurso" => $value["codcurso"], "dniprofesor" => $value["dniprofesor"]);
                array_push($tasksubject, $this->instanciateTaskSubject($this->instanciateTask($task), $this->instanciateSubect($subject)));
            }
            return $tasksubject;

        } else {
            $task = array("codtarea" => $result["codtarea"], "nombretarea" => $result["nombretarea"], "f_inicio" => $result["f_inicio"], "f_fin" => $result["f_fin"], "estado" => $result["estado"], "descrip" => $result["descrip"]);
            $subject = array("codasig" => $result["codasig"], "nombreasignatura" => $result["nombreasignatura"], "n_horas" => $result["n_horas"], "año_fin" => $result["año_fin"], "codcurso" => $result["codcurso"], "dniprofesor" => $result["dniprofesor"]);
            return $this->instanciateTaskSubject($this->instanciateTask($task), $this->instanciateSubect($subject));
        }
    }
    public function  getAllSubject():array{
        return $this->database->select('asignatura',["nombreasignatura"]);
    }
}
