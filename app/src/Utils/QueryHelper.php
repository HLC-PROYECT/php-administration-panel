<?php

namespace HLC\AP\Utils;

use Medoo\Medoo;
use Subject\subject;
use Task\Task;
use TaskSubject\TaskSubject;
use Course\Course;

final class QueryHelper
{
    private Medoo $database;
    private const SQL_GET_SUBJECTS_BY_DNI = "select * from tarea t left join asignatura a on t.codasig = a.codasig where dniprofesor = ";

    public function __construct()
    {
        $this->database = DatabaseConnection::getDatabaseInstance()
            ->getMedooDatabase();
    }
    private function instanciateTask(array $task): Task
    {
        return new Task(
            intval($task["codtarea"]),
            $task["nombretarea"],
            $task["descrip"],
            $task["f_inicio"],
            $task["f_fin"],
            $task["estado"]
        );
    }
    
    private function instanciateSubect(array $subject): subject
    {
        return new subject(
            intval($subject["codasig"]),
            $subject["nombreasignatura"],
            intval($subject["n_horas"]),
            intval($subject["año_fin"]),
            intval($subject["codcurso"]),
            $subject["dniprofesor"]
        );
    }

    private function instanciateTaskSubject(Task $task, subject $subject): TaskSubject
    {
        return new TaskSubject($task, $subject);
    }

    /** @return TaskSubject[] */
    public function getTaskSubjectUsingDni(string $dni): array
    {
        $result = $this->database->query(self::SQL_GET_SUBJECT_BY_DNI . "'{$dni}'")->fetchAll();

        if (!is_array($result)) {
            $result[] = $result;
        }

        $tasksubject = array();
        foreach ($result as $key => $value) {
            $task = array(
                "codtarea" => $value["codtarea"],
                "nombretarea" => $value["nombretarea"],
                "f_inicio" => $value["f_inicio"],
                "f_fin" => $value["f_fin"],
                "estado" => $value["estado"],
                "descrip" => $value["descrip"]
            );
            $subject = array(
                "codasig" => $value["codasig"],
                "nombreasignatura" => $value["nombreasignatura"],
                "n_horas" => $value["n_horas"],
                "año_fin" => $value["año_fin"],
                "codcurso" => $value["codcurso"],
                "dniprofesor" => $value["dniprofesor"]
            );
            array_push(
                $tasksubject,
                $this->instanciateTaskSubject(
                    $this->instanciateTask($task),
                    $this->instanciateSubect($subject)
                )
            );
        }

        return $tasksubject;
    }

    public function  getAllSubject():array
    {
        return $this->database->select('asignatura',["nombreasignatura"]);
    }
}
