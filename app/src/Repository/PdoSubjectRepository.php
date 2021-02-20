<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\subjectRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;

class PdoSubjectRepository implements subjectRepositoryInterface
{
    private Medoo $database;

    public function __construct(private DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    public function save(int $subjectId, string $name, int $numHours, int $yearEnd, int $courseId, string $identificationDocumentTeacher): bool
    {
        //TODO(): Cambiar todos los nombres en la base de datos
        $r = $this->database->insert("asignatura", ["codasig" => $subjectId, "nombreasignatura" => $name, "n_horas" => $numHours,
            "anyo_fin" => $yearEnd, "codcurso" => $courseId, "dniprofesor" => $identificationDocumentTeacher]);
        if ($r->errorCode() == '00000') {
            return true;
        } else {
            //TODO(): ERROR: Añadir error al session
            return false;
        }
    }

    public function get(): Subject|array|null
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
        }
        $subject = array("codasig" => $r["codasig"], "nombreasignatura" => $r["nombreasignatura"], "n_horas" => $r["n_horas"], "anyo_fin" => $r["anyo_fin"], "codcurso" => $r["codcurso"], "dniprofesor" => $r["dniprofesor"]);
        return $this->instantiate($subject);
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

    private function instantiate(array $subject): subject
    {
        return Subject::build(
            intval($subject['codasig']),
            $subject['nombreasignatura'],
            intval($subject['n_horas']),
            intval($subject['anyo_fin']),
            intval($subject['codcurso']),
            $subject['dniprofesor']);
    }

    public function getAllSubject(): array
    {
        return $this->database->select('asignatura', '*');
    }
}