<?php

namespace HLC\AP\Domain\Subject;

use HLC\AP\Domain\Course\Course;

interface SubjectRepositoryInterface
{
    public function save(Subject $subject): bool;

    /** @return Subject[] */
    public function get(): array;

    public function deleteById(int $subjectId): bool;

    public function getById(int $subjectId): ?Subject;

    public function getName(int $subjectId): String;

    public function getCourse(int $subjectId): ?Course;

    public function getTotalHours(int $subjectId): int;

    public function getTeacherId(int $subjectId): int;

    /**
     * @param string $id
     * @return Subject[]
     */
    public function getByTeacherId(string $id): array;
}
