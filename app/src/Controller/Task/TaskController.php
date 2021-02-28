<?php

namespace HLC\AP\Controller\Task;

use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Domain\TaskSubject\TaskSubject;
use HLC\AP\Domain\TaskSubject\TaskSubjectRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;

class TaskController
{
    protected ?User $user;
    /** @var TaskSubject[] */
    protected array $task;
    /** @var Subject[] */
    protected array $subjects;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TaskSubjectRepositoryInterface $taskSubjectRepository,
        private SubjectRepositoryInterface $subjectRepository,
        private TaskRepositoryInterface $taskRepository
    ) {
    }

    public function execute(): string
    {
        $this->user = $this->userRepository->getByDni($_SESSION['uid']);
        $this->task = $this->taskSubjectRepository->getTaskSubjectUsingDni($this->user->getIdentificationDocument());
        $this->subjects = $this->subjectRepository->get();
        return require __DIR__ . '/../../Views/Task/Task.php';
    }
}