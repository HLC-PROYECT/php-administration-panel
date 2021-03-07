<?php

namespace HLC\AP\Domain\Course;

interface CourseRepositoryInterface
{
    public function insert(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool;

    public function save(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): string;

    public function update(int $courseId, string $educationCenter, int $yearStart, int $yearEnd, string $description): bool;

    public function getLastCourseInserted():int;

    public function delete(int $courseId): bool;

    public function getById(int $courseId): ?Course;

    public function getCoursesById($identificationDocument, $order): array;
}
