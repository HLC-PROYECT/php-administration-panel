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

    /** @return Task[] */
    public function get(): array;

    public function deleteById(int $taskId): bool;

    /**
     * @param int $taskId
     * @return Task
     * @throws Exception
     */
    public function getById(int $taskId): Task;
}
