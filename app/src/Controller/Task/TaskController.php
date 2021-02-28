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
        if (isset($_POST['saveTask'])) {
            if ($this->saveTask()) {
                array_push($this->errors,ErrorsMessages::getError("task:insertFailed"));
            }
            unset($_POST['saveTask']);
        }
        
        $this->user = $this->userRepository->getByDni($_SESSION['uid']);
        $this->task = $this->taskSubjectRepository->getTaskSubjectUsingDni($this->user->getIdentificationDocument());
        $this->subjects = $this->subjectRepository->get();
        return require __DIR__ . '/../../Views/Task/Task.php';
    }

    public function saveTask(): bool
    {
        $fail = false;
        if (empty($this->errors)) {

            $result = array();
            $endDate = strtotime($_POST['ffin']);
            $startDate = strtotime($_POST['finicio']);
            $date = new DateTime();
            $actualDate = $date->getTimestamp();
            if (empty(trim($_POST["name"])) || empty(trim($_POST['desc']))) {
                array_push($this->errors, ErrorsMessages::getError("generic:emptyFields"));
                $fail = true;
            }
            if ($endDate < $actualDate) {
                array_push($this->errors, ErrorsMessages::getError("date:lessActual"));
                $fail = true;
            }
            if ($endDate < $startDate) {
                array_push($this->errors, ErrorsMessages::getError("date:EndLessStart"));
                $fail = true;
            }
            if (!$fail) {
                $res = $this->taskRepository->save($_POST['name'], date("Y-m-d", strtotime($_POST['finicio'])), date("Y-m-d", strtotime($_POST['ffin'])), "pendiente", $_POST['desc'], intval($_POST['asigs']));
                if (!$res) {
                    //TODO: ERROR: Nuevo mensaje
                    array_push($this->errors, ErrorsMessages::getError("email:repeat"));
                }
            }
        }
        return $fail;
    }
}