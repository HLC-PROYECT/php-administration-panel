<?php

namespace HLC\AP\Domain\Task;

use DateTime;

final class Task
{
    private int $taskId;
    private string $name;
    private string $description;
    private string $dateStart;
    private string $dateEnd;
    private string $status;
    private string $subjectId;

    private function __construct(
        int $taskId,
        string $name,
        string $description,
        string $dateStart,
        string $dateEnd,
        string $status,
        string $subjectId
    )
    {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->description = $description;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->status = $status;
        $this->subjectId = $subjectId;
    }

    public static function build(
        int $taskId,
        string $name,
        string $description,
        string $dateStart,
        string $dateEnd,
        string $status,
        string $subjectId
    ): self
    {
        return new self(
            $taskId,
            $name,
            $description,
            $dateStart,
            $dateEnd,
            $status,
            $subjectId
        );
    }

    public function getTaskId(): int
    {
        return $this->taskId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSubjectId(): string
    {
        return $this->subjectId;
    }

    /*    public function status(bool $isTeacher): string
        {
            if (false === $isTeacher) {
                return $this->status;
            } else {

            }

        }*/

    public function getTeacherStatus(): string
    {
        $date = new DateTime();
        $actualDate = $date->getTimestamp();
        $end = strtotime($this->dateEnd);
        if ($end < $actualDate) {
            return '<span class="status--process">finalizada</span>';
        }
        //TODO(): Cambiar en base de datos forma del estado, quitar en profesor
        //Cambiar de tarea alumno completada por complete
        return '<span class="status--denied">pendiente</span>';
    }

    public function getStudentStatus(): string
    {
        return ($this->getStatus() === '1') ?
            '<span class="status--process">entregada</span>' :
            '<span class="status--denied">pendiente</span>';
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
