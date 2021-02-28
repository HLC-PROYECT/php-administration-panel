<?php

namespace HLC\AP\Domain\TaskSubject;

use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Task\Task;

class TaskSubject
{
    private Task $task;
    private Subject $subject;

    public function __construct(Task $task, Subject $subject)
    {
        $this->task = $task;
        $this->subject = $subject;
    }

    public static function build(Task $task, Subject $subject): self {
        return new self($task, $subject);
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }
}
