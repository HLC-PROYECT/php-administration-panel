<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\Task\Task;
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

    public function getByTeacherId(string $id, string $filter = "all"): array
    {
        if ($filter === "all") {
            $where = [
                "curso_profesor.dniprofesor" => $id
            ];
        } else {
            $where = [
                "curso_profesor.dniprofesor" => $id,
                "tarea.estado" => $filter
            ];
        }
        $result = $this->database->select("asignatura",
            [
                "[><]curso_profesor" => "codcurso",
                "[><]tarea" => "codasig",

            ],
            [
                "asignatura.codasig",
                "asignatura.nombreasignatura",
                "asignatura.n_horas",
                "asignatura.anyo_fin",
                "asignatura.codcurso",
                "asignatura.dniprofesor",
                "tarea" => [
                    "codtarea",
                    "nombretarea",
                    "f_inicio",
                    "f_fin",
                    "estado",
                    "descrip",
                    "codasig"
                ]
            ],
            $where
        );
        if (true === empty($result)) {
            return [];
        }

        $result = self::mergeSubjectTasks($result);
        $subjects = [];
        foreach ($result as $rawSubject) {
            $subjects[] = $this->build($rawSubject);
        }
        return $subjects;
    }

    public function getByStudentId(string $id, string $filter = "all"): array
    {
        if ($filter === "all") {
            $where = [
                "tarea_alumno.dni" => $id
            ];
        } else {
            $filter = $filter == "completada" ? 1 : 0;
            $where = [
                "tarea_alumno.dni" => $id,
                "tarea_alumno.completada" => $filter
            ];
        }
        $result = $this->database->select("asignatura",
            [
                "[><]tarea" => "codasig",
                "[><]tarea_alumno" => "codtarea",
            ],
            [
                "asignatura.codasig",
                "asignatura.nombreasignatura",
                "asignatura.n_horas",
                "asignatura.anyo_fin",
                "asignatura.codcurso",
                "asignatura.dniprofesor",
                "tarea" => [
                    "codtarea",
                    "nombretarea",
                    "f_inicio",
                    "f_fin",
                    "tarea_alumno.completada",
                    "descrip",
                    "codasig"
                ]
            ],
            $where
        );
        if (true === empty($result)) {
            return [];
        }

        $result = self::mergeSubjectTasks($result);
        $subjects = [];
        foreach ($result as $rawSubject) {
            $subjects[] = $this->build($rawSubject);
        }
        return $subjects;
    }

    private function build(array $subject): subject
    {
        return Subject::build(
            intval($subject['codasig']),
            $subject['nombreasignatura'],
            intval($subject['n_horas']),
            intval($subject['anyo_fin']),
            intval($subject['codcurso']),
            $subject['dniprofesor'],
            self::arrayTaskBuild($subject['tareas'] ?? [])
        );
    }

    public function getName(int $subjectId): string
    {
        // TODO: Implement getName() method.
    }

    public function getCourse(int $subjectId): ?Course
    {
        // TODO: Implement getCourse() method.
        return null;
    }

    public function getTotalHours(int $subjectId): int
    {
        // TODO: Implement getTotalHours() method.
    }

    public function getTeacherId(int $subjectId): int
    {
        // TODO: Implement getTeacherId() method.
    }

    private static function mergeSubjectTasks(array $rows): array
    {
        $subjects = [];
        $aux = [];
        foreach ($rows as $row) {
            $aux[$row['codasig']][] = $row;
        }

        foreach ($aux as $rowSubject) {
            $subject = $rowSubject[0];
            unset($subject["tarea"]);
            foreach ($rowSubject as $row) {
                $subject["tareas"][] = $row["tarea"];
            }
            $subjects[] = $subject;
        }
        return $subjects;
    }

    /**
     * @param array $rawTasks
     * @return Task[]
     */
    private static function arrayTaskBuild(array $rawTasks): array
    {
        $tasks = [];
        foreach ($rawTasks as $rawTask) {

            $tasks[] = Task::build(
                intval($rawTask["codtarea"]),
                $rawTask["nombretarea"],
                $rawTask["descrip"],
                $rawTask["f_inicio"],
                $rawTask["f_fin"],
                isset($rawTask["estado"]) ? $rawTask["estado"] : $rawTask['completada'],
                $rawTask["codasig"]
            );
        }
        return $tasks;
    }

    public function getTeacherSubjects(string $id): array
    {
        $result = $this->database->select("asignatura",
            [
                "[><]curso_profesor" => "codcurso",
            ],
            [
                "asignatura.codasig",
                "asignatura.nombreasignatura",
                "asignatura.n_horas",
                "asignatura.anyo_fin",
                "asignatura.codcurso",
                "asignatura.dniprofesor",
            ],
            [
                "curso_profesor.dniprofesor" => $id
            ]
        );

        if (true === empty($result)) {
            return [];
        }
        $subjects = [];
        foreach ($result as $rawSubject) {
            $subjects[] = $this->build($rawSubject);
        }
        return $subjects;
    }
}