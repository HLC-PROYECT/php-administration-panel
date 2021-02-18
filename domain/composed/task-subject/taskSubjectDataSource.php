<?php


namespace TaskSubject;


use Subject\subject;
use Task\task;

interface taskSubjectDataSource
{
    public function instantiate(task $task, subject $subject): ?taskSubject;

    public function getTaskSubjectUsingDni(string $dni): taskSubject|array|null;
}