<?php

namespace HLC\AP\Domain\CourseTeacher;

use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Teacher\Teacher;

class TaskSubject
{
    private Course $course;
    private Teacher $teacher;

    public function __construct(Course $course, Teacher $teacher)
    {
        $this->course = $course;
        $this->teacher = $teacher;
    }
    public static function build(Course $teacher, Teacher $teacher): self {
        return new self($task, $subject);
    }
    public function getCourse(): Course
    {
        return $this->course;
    }

    public function getSubject(): Teacher
    {
        return $this->teacher;
    }
}