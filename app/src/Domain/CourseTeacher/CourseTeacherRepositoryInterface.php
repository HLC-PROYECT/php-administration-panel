<?php

namespace HLC\AP\Domain\CourseTeacher;

interface CourseTeacherRepositoryInterface
{
    public function insert(int $courseID, string $identificationDocument);

    public function deleteByCourse(int $courseID);
}