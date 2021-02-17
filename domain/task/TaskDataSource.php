<?php


namespace Task;


interface TaskDataSource
{
    public function save(int $codTask, string $taskName, string $initialDate, string $endDate, string $state, string $des, int $codSubject): bool;

    public function get(): Task|array;

    public function deleteById(int $taskId): bool;

    public function getById(int $taskId): Task;

    public function instantiate(array $task): Task;
}