<?php

namespace HLC\AP\Domain\Course;

class Course
{
    private int $courseId;
    private string $educationCenter;
    private int $yearStart;
    private int $yearEnd;
    private string $description;

    public function __construct(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description)
    {
        $this->courseId = $courseId;
        $this->educationCenter = $educationCenter;
        $this->yearStart = $yearStart;
        $this->yearEnd = $yearEnd;
        $this->description = $description;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function getEducationCenter(): string
    {
        return $this->educationCenter;
    }

    public function getYearStart(): int
    {
        return $this->yearStart;
    }

    public function getYearEnd(): int
    {
        return $this->yearEnd;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public static function build( int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): self {
        return  new self($courseId,$educationCenter,$yearStart,$yearEnd,$description);
    }
}
