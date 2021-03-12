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

    /**
     * @param string $teacherId
     * @return Subject[]
     */
    public function getTeacherSubjectOrderByID(string $teacherId): array;

    /**
     * @param string $teacherId
     * @return Subject[]
     */
    public function getTeacherSubjectOrderByCourseId(string $teacherId): array;

    /**
     * @param string $teacherId
     * @return Subject[]
     */
    public function getTeacherSubjectOrderByNumHours(string $teacherId): array;

    /**
     * @param string $teacherId
     * @return Subject[]
     */
    public function getTeacherSubjectOrderByName(string $teacherId): array;

    /**
     * @param string $id
     * @param string $filter
     * @return Subject[]
     */
    public function getByTeacherId(string $id, string $filter): array;

    /**
     * @param string $studentId
     * @return Subject[]
     */
    public function getStudentSubjectOrderByName(string $studentId): array;

    /**
     * @param string $studentId
     * @return Subject[]
     */
    public function getStudentSubjectOrderByNumHours(string $studentId): array;

    /**
     * @param string $studentId
     * @return Subject[]
     */
    public function getStudentSubjectOrderByCourseId(string $studentId): array;

    /**
     * @param string $studentId
     * @return Subject[]
     */
    public function getStudentSubjectOrderByID(string $studentId): array;

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
