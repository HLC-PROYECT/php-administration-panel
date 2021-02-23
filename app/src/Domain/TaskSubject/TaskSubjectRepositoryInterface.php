<?php

namespace HLC\AP\Domain\TaskSubject;

interface TaskSubjectRepositoryInterface
{
    public function getCourseTeacherByID(string $identificationDocument): taskSubject|array|null;
    public function insertCourseTeacher(int $courseID, string $identificationDocument);
}