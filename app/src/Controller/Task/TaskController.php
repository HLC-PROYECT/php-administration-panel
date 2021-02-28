<?php


namespace HLC\AP\Controller\Task;


use DateTime;
use HLC\AP\Repository\PdoSubjectRepository;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Repository\PdoTaskSubjectRepository;
use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\ErrorsMessages;

class TaskController
{
    //TODO: Refactorizar y validar
    private $errors = [];

    public function __construct(
        private PdoUserRepository $userRepository,
        private PdoTaskSubjectRepository $TaskSubjectRepository,
        private PdoSubjectRepository $subjectRepository,
        private PdoTaskRepository $taskRepository
    )
    {
    }

    public function execute(): string
    {
        if (isset($_POST['saveTask'])) {
            if ($this->saveTask()) {
                array_push($this->errors,ErrorsMessages::getError("task:insertFailed"));
            }
            unset($_POST['saveTask']);
        }
        $user = $this->userRepository->getByDni($_SESSION['uid']);
        $task = $this->TaskSubjectRepository->getTaskSubjectUsingDni($user->getIdentificationDocument());
        $subjectNames = $this->subjectRepository->get();
        return require __DIR__ . '/../../Views/task/task.php';
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