<?php

namespace HLC\AP\Domain\Subject;

use DateTime;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\Teacher\Teacher;
use HLC\AP\Domain\User\User;

final class Subject
{
    public int $subjectId;
    public string $name;
    public int $numHours;
    public int $yearEnd;
    public Course $course;
    public User $teacher;
    /** @var Task[] */
    private array $tasks;
    private ?DateTime $dateStart;
    private ?DateTime $dateEnd;
    private ?DateTime $dateUpdate;

    public function __construct(
        int $subjectId,
        string $name,
        int $numHours,
        int $yearEnd,
        Course $course,
        User $teacher,
        array $tasks = [],
        DateTime $dateStart = null,
        DateTime $dateEnd = null,
        DateTime $dateUpdate = null
    )
    {
        $this->subjectId = $subjectId;
        $this->name = $name;
        $this->numHours = $numHours;
        $this->yearEnd = $yearEnd;
        $this->course = $course;
        $this->teacher = $teacher;
        $this->tasks = $tasks;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->dateUpdate = $dateUpdate;
    }

    public static function build(
        int $subjectId,
        string $name,
        int $numHours,
        int $yearEnd,
        Course $course,
        User $teacher,
        array $tasks = [],
        DateTime $dateStart = null,
        DateTime $dateEnd = null,
        DateTime $dateUpdate = null
    ): self
    {
        return new self(
            $subjectId,
            $name,
            $numHours,
            $yearEnd,
            $course,
            $teacher,
            $tasks,
            $dateStart,
            $dateEnd,
            $dateUpdate
        );
    }

    public function getId(): int
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

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getCourseDescription(): string
    {
        return $this->course->getDescription();
    }

    public function getTeacher(): User
    {
        return $this->teacher;
    }

    public function getTeacherName(): string
    {
        return $this->teacher->getName();
    }

    public function getIdentificationDocumentTeacher(): string
    {
        return $this->identificationDocumentTeacher;
    }

    /** @return Task[] */
    public function getTasks(): array
    {
        return $this->tasks;
    }

}
