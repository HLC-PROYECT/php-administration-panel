<?php


namespace Subject;


use Medoo\Medoo;

class PdoSubjectRepository implements subjectDataSource
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


    public function save(int $codSubject, string $subjectName, int $numberOfHours, int $endYear, int $codCourse, string $teacherDni): bool
    {
        //TODO(): Cambiar todos los nombres en la base de datos
        $r = $this->database->insert("asignatura", ["codasig" => $codSubject, "nombreasignatura" => $subjectName, "n_horas" => $numberOfHours,
            "anyo_fin" => $endYear, "codcurso" => $codCourse, "dniprofesor" => $teacherDni]);
        if ($r->errorCode() == '00000') {
            return true;
        } else {
            //TODO(): ERROR: Añadir error al session
            return false;
        }
    }

    public function get(): subject|array|null
    {
        $r = $this->database->select("asignatura", "*");
        if (is_array($r)) {
            $sub = array();
            foreach ($r as $key => $value) {
                $subject = array("codasig" => $value["codasig"], "nombreasignatura" => $value["nombreasignatura"], "n_horas" => $value["n_horas"], "anyo_fin" => $value["anyo_fin"], "codcurso" => $value["codcurso"], "dniprofesor" => $value["dniprofesor"]);
                array_push($tasks, $this->instantiate($subject));
            }
            return $sub;

        } elseif ($r == null) {
            return null;
        } else {
            $subject = array("codasig" => $r["codasig"], "nombreasignatura" => $r["nombreasignatura"], "n_horas" => $r["n_horas"], "anyo_fin" => $r["anyo_fin"], "codcurso" => $r["codcurso"], "dniprofesor" => $r["dniprofesor"]);
            return $this->instantiate($subject);
        }
    }

    public function deleteById(int $subjectId): bool
    {
        $r = $this->database->delete("asignatura", ["codasig" => $subjectId]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getById(int $subjectId): ?subject
    {
        return $this->instantiate($this->database->select("asignatura", "*", ["codasig" => $subjectId]));

    }

    public function instantiate(array $subject): subject
    {
        return new subject(intval($subject['codasig']), $subject['nombreasignatura'], intval($subject['n_horas']), intval($subject['anyo_fin']), intval($subject['codcurso']), $subject['dniprofesor']);
    }

    public function getAllSubject(): array
    {
        return $this->database->select('asignatura', '*');
    }
}