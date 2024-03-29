<?php

namespace HLC\AP\Repository;

use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\Teacher\Teacher;
use HLC\AP\Domain\User\User;
use HLC\AP\Utils\DatabaseConnection;
use Medoo\Medoo;

class PdoSubjectRepository implements SubjectRepositoryInterface
{
    private const ASIGNATURA_CODASIG = "asignatura.codasig";
    private const ASIGNATURA_NOMBREASIGNATURA = "asignatura.nombreasignatura";
    private const ASIGNATURA_N_HORAS = "asignatura.n_horas";
    private const ASIGNATURA_CODCURSO = "asignatura.codcurso";
    private Medoo $database;

    public function __construct(private DatabaseConnection $databaseConnection)
    {
        $this->database = $databaseConnection->getMedooDatabase();
    }

    public function save(Subject $subject): bool
    {
        $responseQuery = $this->database->insert("asignatura",
            [
                "codasig" => $subject->getId(),
                "nombreasignatura" => $subject->getName(),
                "n_horas" => $subject->getNumHours(),
                "anyo_fin" => $subject->getYearEnd(),
                "codcurso" => $subject->getCourse()->getCourseId(),
                "dniprofesor" => $subject->getTeacher()->getIdentificationDocument()
            ]
        );

        return $responseQuery->errorCode() === '00000';
    }

    public function update(Subject $subject): bool
    {
        $responseQuery = $this->database->update("asignatura",
            [
                "codasig" => $subject->getId(),
                "nombreasignatura" => $subject->getName(),
                "n_horas" => $subject->getNumHours(),
                "anyo_fin" => $subject->getYearEnd(),
                "codcurso" => $subject->getCourse()->getCourseId(),
                "dniprofesor" => $subject->getTeacher()->getIdentificationDocument()
            ],
            [
                "codasig" => $subject->getId()
            ]
        );

        return $responseQuery->errorCode() === '00000';
    }

    public function get(): array
    {
        $responseQuery = $this->database->select("asignatura",
            [
                "[><]curso" => "codcurso",
                "[><]usuario" => ["dniprofesor" => "dni"]
            ],
            [
                self::ASIGNATURA_CODASIG,
                self::ASIGNATURA_NOMBREASIGNATURA,
                self::ASIGNATURA_N_HORAS,
                "asignatura.anyo_fin",
                "curso" => [
                    "curso.codcurso",
                    "curso.centroed",
                    "curso.descrip"
                ],
                "profesor" => [
                    "usuario.dni",
                    "usuario.email",
                    "usuario.nomb_usuario",
                    "usuario.password",
                    "usuario.nombre",
                    "usuario.f_alta",
                    "usuario.tipo"
                ]
            ]
        );

        $subjects = [];
        foreach ($responseQuery as $row) {
            array_push($subjects, $this->build($row));
        }
        return $subjects;
    }

    public function deleteById(int $subjectId): bool
    {
        $responseQuery = $this->database->delete("asignatura", ["codasig" => $subjectId]);

        return $responseQuery->errorCode() === '00000';
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
                self::ASIGNATURA_CODASIG,
                self::ASIGNATURA_NOMBREASIGNATURA,
                self::ASIGNATURA_N_HORAS,
                "asignatura.anyo_fin",
                self::ASIGNATURA_CODCURSO,
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
                self::ASIGNATURA_CODASIG,
                self::ASIGNATURA_NOMBREASIGNATURA,
                self::ASIGNATURA_N_HORAS,
                "asignatura.anyo_fin",
                self::ASIGNATURA_CODCURSO,
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

    private function build(array $subject): Subject
    {
        return Subject::build(
            intval($subject['codasig']),
            $subject['nombreasignatura'],
            intval($subject['n_horas']),
            intval($subject['anyo_fin']),
            Course::build(
                $subject["curso"]["codcurso"] ?? $subject["codcurso"],
                $subject["curso"]["centroed"] ?? "",
                $subject["curso"]["a_inicio"] ?? 0,
                $subject["curso"]["a_fin"] ?? 0,
                $subject["curso"]["descrip"] ?? ""
            ),
            User::build(
                $subject["profesor"]["dni"] ?? $subject["dniprofesor"],
                $subject["profesor"]["email"] ?? "",
                $subject["profesor"]["password"] ?? "",
                $subject["profesor"]["nomb_usuario"] ?? "",
                $subject["profesor"]["nombre"] ?? "",
                $subject["profesor"]["f_alta"] ?? "",
                "",
                "",
                $subject["profesor"]["tipo"] ?? "P"
            ),
            self::arrayTaskBuild($subject['tareas'] ?? [])
        );
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

    public function getSubjectByTeacherId(string $id): array
    {
        $result = $this->database->select("asignatura",
                [
                    "[><]curso" => "codcurso",
                    "[><]usuario" => ["dniprofesor" => "dni"],
                    "[><]curso_profesor" => "codcurso"
                ],
                [
                    self::ASIGNATURA_CODASIG,
                    self::ASIGNATURA_NOMBREASIGNATURA,
                    self::ASIGNATURA_N_HORAS,
                    "asignatura.anyo_fin",
                    "curso" => [
                        "curso.codcurso",
                        "curso.centroed",
                        "curso.descrip"
                    ],
                    "profesor" => [
                        "usuario.dni",
                        "usuario.email",
                        "usuario.nomb_usuario",
                        "usuario.password",
                        "usuario.nombre",
                        "usuario.f_alta",
                        "usuario.tipo"
                    ]
                ],
                [
                    "curso_profesor.dniprofesor" => $id
                ]
        );

        $subjects = [];
        foreach ($result as $rawSubject) {
            $subjects[] = $this->build($rawSubject);
        }

        return $subjects;
    }

    public function getTeacherSubjectOrderByID(string $teacherId): array
    {
        return $this->getTeacherFilter(self::ASIGNATURA_CODASIG, $teacherId);
    }

    public function getTeacherSubjectOrderByName(string $teacherId): array
    {
        return $this->getTeacherFilter(self::ASIGNATURA_NOMBREASIGNATURA, $teacherId);
    }

    public function getTeacherSubjectOrderByNumHours(string $teacherId): array
    {
        return $this->getTeacherFilter(self::ASIGNATURA_N_HORAS, $teacherId);
    }

    public function getTeacherSubjectOrderByCourseId(string $teacherId): array
    {
        return $this->getTeacherFilter(self::ASIGNATURA_CODCURSO, $teacherId);
    }


    public function getStudentSubjectOrderByID(string $studentId): array
    {
        return $this->getStudentFilter(self::ASIGNATURA_CODASIG, $studentId);
    }

    public function getStudentSubjectOrderByName(string $studentId): array
    {
        return $this->getStudentFilter(self::ASIGNATURA_NOMBREASIGNATURA, $studentId);
    }

    public function getStudentSubjectOrderByNumHours(string $studentId): array
    {
        return $this->getStudentFilter(self::ASIGNATURA_N_HORAS, $studentId);
    }

    public function getStudentSubjectOrderByCourseId(string $studentId): array
    {
        return $this->getStudentFilter(self::ASIGNATURA_CODCURSO, $studentId);
    }

    private function getStudentFilter(string $columnFilter, string $studentId): array
    {
        $responseQuery = $this->database->select("asignatura",
            [
                "[><]alumno" => "codcurso",
                "[><]curso" => "codcurso",
                "[><]usuario" => ["dni"],
            ],
            [
                self::ASIGNATURA_CODASIG,
                self::ASIGNATURA_NOMBREASIGNATURA,
                self::ASIGNATURA_N_HORAS,
                "asignatura.anyo_fin",
                "curso" => [
                    "curso.codcurso",
                    "curso.centroed",
                    "curso.descrip"
                ],
                "profesor" => [
                    "usuario.dni",
                    "usuario.email",
                    "usuario.nomb_usuario",
                    "usuario.password",
                    "usuario.nombre",
                    "usuario.f_alta",
                    "usuario.tipo"
                ]
            ],
            [
                "alumno.dni" => $studentId,
                "ORDER" => $columnFilter
            ]
        );

        $subjects = [];
        foreach ($responseQuery as $row) {
            array_push($subjects, $this->build($row));
        }
        return $subjects;
    }

    private function getTeacherFilter(string $columnFilter, string $teacherId): array
    {
        $responseQuery = $this->database->select("asignatura",
            [
                "[><]curso" => "codcurso",
                "[><]usuario" => ["dniprofesor" => "dni"],
                "[><]curso_profesor" => "codcurso"
            ],
            [
                self::ASIGNATURA_CODASIG,
                self::ASIGNATURA_NOMBREASIGNATURA,
                self::ASIGNATURA_N_HORAS,
                "asignatura.anyo_fin",
                "curso" => [
                    "curso.codcurso",
                    "curso.centroed",
                    "curso.descrip"
                ],
                "profesor" => [
                    "usuario.dni",
                    "usuario.email",
                    "usuario.nomb_usuario",
                    "usuario.password",
                    "usuario.nombre",
                    "usuario.f_alta",
                    "usuario.tipo"
                ]
            ],
            [
                "curso_profesor.dniprofesor" => $teacherId,
                "ORDER" => $columnFilter
            ]
        );

        $subjects = [];
        foreach ($responseQuery as $row) {
            array_push($subjects, $this->build($row));
        }
        return $subjects;
    }
}
