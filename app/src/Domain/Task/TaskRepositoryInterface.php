<?php

namespace HLC\AP\Domain\Task;

interface TaskRepositoryInterface
{
    public function save(
        string $name,
        string $dateStart,
        string $dateEnd,
        string $status,
        string $description,
        int $subjectId
    ): bool;

    /** @return Task[] */
    public function get(): array;

    public function deleteById(int $taskId): bool;

    public function getById(int $taskId): ?Task;
}
