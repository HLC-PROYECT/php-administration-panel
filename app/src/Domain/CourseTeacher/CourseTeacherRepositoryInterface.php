<?php

namespace HLC\AP\Domain\CourseTeacher;

interface CourseTeacherRepositoryInterface
{
    public function insertCourseTeacher(int $courseID, string $identificationDocument);
}