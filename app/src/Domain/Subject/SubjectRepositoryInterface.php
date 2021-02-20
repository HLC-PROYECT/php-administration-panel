<?php

namespace HLC\AP\Domain\Subject;

interface SubjectRepositoryInterface
{
    public function save(int $subjectId, string $name, int $numHours, int $yearEnd, int $courseId, string $identificationDocumentTeacher): bool;

    public function get(): subject|array|null;

    public function deleteById(int $subjectId): bool;

    public function getById(int $subjectId): ?Subject;

    public function getAllSubject(): array;
}
