<?php

namespace HLC\AP\Domain\Course;

interface CourseRepositoryInterface
{
    public function save(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool;

    public function delete(int $courseId): bool;

    public function getById(int $courseId): ?Course;

    public function getAllCourses(): array;

    public function getTeacherCourses(): array;
}
