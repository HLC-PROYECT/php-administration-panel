<?php


namespace TaskSubject;


use Subject\subject;
use Task\task;

class taskSubject
{
    private task $task;
    private subject $subject;

    /**
     * taskSubject constructor.
     * @param task $task
     * @param subject $subject
     */

    public function __construct(task $task, subject $subject)
    {
        $this->task = $task;
        $this->subject = $subject;
    }

    /**
     * @return task
     */
    public function getTask(): task
    {
        return $this->task;
    }

    /**
     * @return subject
     */
    public function getSubject(): subject
    {
        return $this->subject;
    }


}