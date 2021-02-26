<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Subject\Course;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;

class PdoSubjectRepository implements SubjectRepositoryInterface
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

    public function get(): array
    {
        $responseQuery = $this->database->select("asignatura", "*");
        $subjects = [];
        foreach ($responseQuery as $row) {
            array_push($subjects, $this->build($row));
        }
        return $subjects;
    }

    public function deleteById(int $subjectId): bool
    {
        $r = $this->database->delete("asignatura", ["codasig" => $subjectId]);
        if ($r->errorCode() == '00000') return true;
        else return false;
    }

    public function getById(int $subjectId): ?subject
    {
        return $this->build($this->database->select("asignatura", "*", ["codasig" => $subjectId]));
    }

    private function build(array $subject): subject
    {
        return Subject::build(
            intval($subject['codasig']),
            $subject['nombreasignatura'],
            intval($subject['n_horas']),
            intval($subject['anyo_fin']),
            intval($subject['codcurso']),
            $subject['dniprofesor']);
    }

    public function getName(int $subjectId): string
    {
        // TODO: Implement getName() method.
    }

    public function getCourse(int $subjectId): ?Course
    {
        // TODO: Implement getCourse() method.
    }

    public function getTotalHours(int $subjectId): int
    {
        // TODO: Implement getTotalHours() method.
    }

    public function getTeacherId(int $subjectId): int
    {
        // TODO: Implement getTeacherId() method.
    }
}