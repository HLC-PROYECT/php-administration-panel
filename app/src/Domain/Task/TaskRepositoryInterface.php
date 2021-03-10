<?php

namespace HLC\AP\Domain\Task;

use Exception;

interface TaskRepositoryInterface
{
    /**
     * @param Task $task
     * @return Task
     * @throws Exception
     */
    public function save(Task $task): Task;

    /**
     * @param bool $isTeacher
     * @return Task[]
     */
    public function get( bool $isTeacher): array;

    public function deleteById(int $taskId): bool;

    /**
     * @param int $taskId
     * @return Task
     * @throws Exception
     */
    public function getById(int $taskId): Task;

    public function send(string $dni, string $taskId): bool;
    public function updateTeacherCompleted(Task $task): void;
}
