<?php

namespace HLC\AP\Domain\TaskSubject;

interface TaskSubjectRepositoryInterface
{
    /**
     * @param string $identificationDocument
     * @return TaskSubject[]
     */
    public function getTaskSubjectUsingDni(string $identificationDocument): array;
}