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

    private function __construct(
        int $taskId,
        string $name,
        string $description,
        string $dateStart,
        string $dateEnd,
        string $status
    ) {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->description = $description;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->status = $status;
    }

    public static function build(
        int $taskId,
        string $name,
        string $description,
        string $dateStart,
        string $dateEnd,
        string $status
    ): self {
        return new self(
             $taskId,
             $name,
             $description,
             $dateStart,
             $dateEnd,
             $status
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

    public function getStatus(bool $isTeacher): string
    {
        if($isTeacher){
            $date = new DateTime();
            $actualDate = $date->getTimestamp();
            $end = strtotime($this->dateEnd);
            if ($end<$actualDate){
                return "finalizada";
            }else{
                return "pendiente";
            }
        }else{
            return $this->status;
        }
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
