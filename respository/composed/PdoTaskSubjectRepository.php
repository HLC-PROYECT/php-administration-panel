<?php


namespace TaskSubject;


use Medoo\Medoo;
use Subject\PdoSubjectRepository;
use Subject\subject;
use Task\PdoTaskRepository;
use Task\task;

class PdoTaskSubjectRepository implements taskSubjectDataSource
{

    private Medoo $database;
    private PdoTaskRepository $taskRepo;
    private PdoSubjectRepository $subjectRepo;

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
        $this->taskRepo = new PdoTaskRepository();
        $this->subjectRepo = new PdoSubjectRepository();
    }

    public function instantiate(task $task, subject $subject): ?taskSubject
    {
        return new taskSubject($task, $subject);

    }
    public function getTaskSubjectUsingDni(string $dni): taskSubject|array|null
    {
        $result = $this->database->query("select * from tarea t left join asignatura a on t.codasig = a.codasig where dniprofesor = '12345678A'")->fetchAll();
        if (is_array($result)) {
            $tasksubject = array();
            foreach ($result as $key => $value) {
                $task = array("codtarea" => $value["codtarea"], "nombretarea" => $value["nombretarea"], "f_inicio" => $value["f_inicio"], "f_fin" => $value["f_fin"], "estado" => $value["estado"], "descrip" => $value["descrip"]);
                $subject = array("codasig" => $value["codasig"], "nombreasignatura" => $value["nombreasignatura"], "n_horas" => $value["n_horas"], "anyo_fin" => $value["anyo_fin"], "codcurso" => $value["codcurso"], "dniprofesor" => $value["dniprofesor"]);
                array_push($tasksubject, $this->instantiate($this->taskRepo->instantiate($task), $this->subjectRepo->instantiate($subject)));
            }
            return $tasksubject;

        } elseif ($result == null) {
            return null;
        } else {
            $task = array("codtarea" => $result["codtarea"], "nombretarea" => $result["nombretarea"], "f_inicio" => $result["f_inicio"], "f_fin" => $result["f_fin"], "estado" => $result["estado"], "descrip" => $result["descrip"]);
            $subject = array("codasig" => $result["codasig"], "nombreasignatura" => $result["nombreasignatura"], "n_horas" => $result["n_horas"], "anyo_fin" => $result["anyo_fin"], "codcurso" => $result["codcurso"], "dniprofesor" => $result["dniprofesor"]);
            return $this->instantiate($this->taskRepo->instantiate($task), $this->subjectRepo->instantiate($subject));
        }
    }
}