<?php

namespace HLC\AP\Domain\CourseTeacher;

interface CourseTeacherRepositoryInterface
{
    public function getCourseTeacherByID(string $identificationDocument): taskSubject|array|null;
    public function insertCourse(string $identificationDocument, string $courseID);
}