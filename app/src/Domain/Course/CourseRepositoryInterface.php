<?php

namespace HLC\AP\Domain\Course;

interface CourseRepositoryInterface
{
    public function insert(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool;

    public function delete(int $courseId): bool;

    public function getById(int $courseId): ?Course;

    public function getAllCourses($teacherID): array;

    public function getTeacherCourses(): array;
}