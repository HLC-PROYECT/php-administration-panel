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

    private function instantiate(Task $task, Subject $subject): TaskSubject
    {
        return new TaskSubject($task, $subject);
    }
    /** @return TaskSubject[] */
    public function getTaskSubjectUsingDni(string $identificationDocument): taskSubject|array|null
    {
        $QUERY = "select * from tarea t left join asignatura a on t.codasig = a.codasig where dniprofesor = '$identificationDocument'";

        $result = $this->database->query($QUERY)->fetchAll();
        if (is_array($result)) {
            $taskSubject = array();
            foreach ($result as $key => $value) {

                    $taskId = $value["codtarea"];
                    $taskName = $value["nombretarea"];
                    $taskDateStart =  $value["f_inicio"];
                    $taskDateEnd = $value["f_fin"];
                    $status = $value["estado"];
                    $description = $value["descrip"];


                    $subjectId = $value["codasig"];
                    $subjectName = $value["nombreasignatura"];
                    $subjectNumHours = $value["n_horas"];
                    $subjectDateEnd = $value["anyo_fin"];
                    $courseId =  $value["codcurso"];
                    $identificationDocumentTeacher = $value["dniprofesor"];

                array_push($taskSubject,
                    $this->instantiate(
                        Task::build($taskId,$taskName,$description,$taskDateStart,$taskDateEnd,$status),
                        Subject::build($subjectId,$subjectName,$subjectNumHours,$subjectDateEnd,$courseId,$identificationDocumentTeacher))
                );

            }
            return $taskSubject;

        } elseif ($result == null) {
            return null;
        }
                    $taskId = $result["codtarea"];
                    $taskName = $result["nombretarea"];
                    $taskDateStart =  $result["f_inicio"];
                    $taskDateEnd = $result["f_fin"];
                    $status = $result["estado"];
                    $description = $result["descrip"];


                    $subjectId = $result["codasig"];
                    $subjectName = $result["nombreasignatura"];
                    $subjectNumHours = $result["n_horas"];
                    $subjectDateEnd = $result["anyo_fin"];
                    $courseId =  $result["codcurso"];
                    $identificationDocumentTeacher = $result["dniprofesor"];

            return  $this->instantiate(
                Task::build($taskId,$taskName,$description,$taskDateStart,$taskDateEnd,$status),
                Subject::build($subjectId,$subjectName,$subjectNumHours,$subjectDateEnd,$courseId,$identificationDocumentTeacher)
            );
        }
}
