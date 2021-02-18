<?php


namespace Subject;


interface subjectDataSource
{
    public function save(int $codSubject, string $subjectName, int $numberOfHours, int $endYear, int $codCourse, string $teacherDni): bool;

    public function get(): subject|array|null;

    public function deleteById(int $subjectId): bool;

    public function getById(int $subjectId): ?subject;

    public function instantiate(array $subject): subject;

    public function getAllSubject(): array;

}