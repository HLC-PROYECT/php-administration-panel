<?php

namespace HLC\AP\Domain\Subject;

class Subject
{
    private int $subjectId;
    private string $name;
    private int $numHours;
    private int $yearEnd;
    private int $courseId;
    private string $identificationDocumentTeacher;

    public function __construct(int $subjectId, string $name, int $numHours, int $yearEnd, int $courseId, string $identificationDocumentTeacher)
    {
        $this->subjectId = $subjectId;
        $this->name = $name;
        $this->numHours = $numHours;
        $this->yearEnd = $yearEnd;
        $this->courseId = $courseId;
        $this->identificationDocumentTeacher = $identificationDocumentTeacher;
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

    public static function build(int $subjectId, string $name, int $numHours, int $yearEnd, int $courseId, string $identificationDocumentTeacher): self {
        return new self($subjectId,$name,$numHours,$yearEnd,$courseId,$identificationDocumentTeacher);
    }
}
