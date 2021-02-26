<?php

namespace HLC\AP\Domain\Subject;

interface SubjectRepositoryInterface
{
    public function save(
        int $subjectId,
        string $name,
        int $numHours,
        int $yearEnd,
        int $courseId,
        string $identificationDocumentTeacher
    ): bool;

    /** @return Subject[] */
    public function get(): array;

    public function deleteById(int $subjectId): bool;

    public function getById(int $subjectId): ?Subject;

    public function getName(int $subjectId): String;

    public function getCourse(int $subjectId): ?Course;

    public function getTotalHours(int $subjectId): int;

    public function getTeacherId(int $subjectId): int;
}