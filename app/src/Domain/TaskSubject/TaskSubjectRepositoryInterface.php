<?php

namespace TaskSubject;

use HLC\AP\Domain\TaskSubject\TaskSubject;

interface TaskSubjectRepositoryInterface
{
    public function getTaskSubjectUsingDni(string $identificationDocument): taskSubject|array|null;
}
