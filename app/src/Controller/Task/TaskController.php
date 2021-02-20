<?php


namespace HLC\AP\Controller\Task;


use HLC\AP\Domain\User\User;
use HLC\AP\Repository\PdoSubjectRepository;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Repository\PdoTaskSubjectRepository;
use HLC\AP\Repository\PdoUserRepository;

class TaskController
{
    public function __construct(
        private PdoUserRepository $userRepository,
        private PdoTaskSubjectRepository $TaskSubjectRepository,
        private PdoSubjectRepository $subjectRepository,
        private PdoTaskRepository $taskRepository
    ) {
    }

    public function execute(): string
    {
        $user = $this->userRepository->getByDni($_SESSION['uid']);
        $task = $this->TaskSubjectRepository->getTaskSubjectUsingDni($user->getIdentificationDocument());
        $subjectNames = $this->subjectRepository->getAllSubject();
        return require __DIR__ . '/../../views/task/task.php';
    }
}