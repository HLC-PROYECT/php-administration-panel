<?php


namespace Task;


interface taskDataSource
{
    public function save(int $codTask, string $taskName, string $initialDate, string $endDate, string $state, string $des, int $codSubject): bool;

    public function get(): task|array|null;

    public function deleteById(int $taskId): bool;

    public function getById(int $taskId): ?task;

    public function instantiate(array $task): task;
}