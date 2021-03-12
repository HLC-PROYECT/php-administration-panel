<?php

namespace HLC\AP\Domain\Subject;

use HLC\AP\Domain\Course\Course;

interface SubjectRepositoryInterface
{
    public function save(Subject $subject): bool;

    public function update(Subject $subject): bool;

    /** @return Subject[] */
    public function get(): array;

    public function deleteById(int $subjectId): bool;

    public function getById(int $subjectId): ?Subject;

    /** @return Subject[] */
    public function getTeacherSubjectOrderByID(): array;

    /** @return Subject[] */
    public function getTeacherSubjectOrderByCourseId(): array;

    /** @return Subject[] */
    public function getTeacherSubjectOrderByNumHours(): array;

    /** @return Subject[] */
    public function getTeacherSubjectOrderByName(): array;

    /**
     * @param string $id
     * @param string $filter
     * @return Subject[]
     */
    public function getByTeacherId(string $id, string $filter): array;

    /**
     * @param string $id
     * @param string $filter
     * @return Subject[]
     */
    public function getByStudentId(string $id, string $filter): array;

    /**
     * @param string $id
     * @return Subject[]
     */
    public function getSubjectByTeacherId(string $id): array;
}
