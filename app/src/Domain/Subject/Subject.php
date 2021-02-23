<?php

namespace HLC\AP\Domain\Subject;

use Cassandra\Date;
use DateTime;

class Subject
{
    private int $subjectId;
    private string $name;
    private int $numHours;
    private int $yearEnd;
    private int $courseId;
    private string $identificationDocumentTeacher;
    private DateTime $dateStart;
    private DateTime $dateEnd;
    private DateTime $dateUpdate;

    public function __construct(
        int $subjectId,
        string $name,
        int $numHours,
        int $yearEnd,
        int $courseId,
        string $identificationDocumentTeacher,
        DateTime $dateStart,
        DateTime $dateEnd,
        DateTime $dateUpdate
    ) {
        $this->subjectId = $subjectId;
        $this->name = $name;
        $this->numHours = $numHours;
        $this->yearEnd = $yearEnd;
        $this->courseId = $courseId;
        $this->identificationDocumentTeacher = $identificationDocumentTeacher;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->dateUpdate = $dateUpdate;
    }

    public static function build(
        int $subjectId,
        string $name,
        int $numHours,
        int $yearEnd,
        int $courseId,
        string $identificationDocumentTeacher
    ): self {
        return new self($subjectId, $name, $numHours, $yearEnd, $courseId, $identificationDocumentTeacher);
    }

    public function getSubjectId(): int
    {
        return $this->subjectId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNumHours(): int
    {
        return $this->numHours;
    }

    public function getYearEnd(): int
    {
        return $this->yearEnd;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getIdentificationDocumentTeacher(): string
    {
        return $this->identificationDocumentTeacher;
    }
}
