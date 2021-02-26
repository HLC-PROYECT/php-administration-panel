<?php

namespace HLC\AP\Domain\TaskSubject;

interface TaskSubjectRepositoryInterface
{
    public function getTaskSubjectUsingDni(string $identificationDocument): taskSubject|array|null;
}