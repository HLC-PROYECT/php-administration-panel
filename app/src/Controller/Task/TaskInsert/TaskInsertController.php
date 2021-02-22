<?php


namespace HLC\AP\Controller\Task\TaskInsert;


use DateTime;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Utils\ErrorsMessages;

class TaskInsertController
{
    public function __construct(
        private ErrorsMessages $errorsMessages,
        private PdoTaskRepository $taskRepo,
    ){

    }

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
            $fail = false;
            if (empty($errors)) {
                /*filterAllInputs();*/

                $result = array();
                $endDate = strtotime($_POST['ffin']);
                $startDate = strtotime($_POST['finicio']);
                $date = new DateTime();
                $actualDate = $date->getTimestamp();
                if (empty(trim($_POST["name"])) || empty(trim($_POST['desc']))) {
                    $_SESSION['error'] = $this->errorsMessages->getError("generic:emptyFields");
                    $fail = true;
                } else if ($endDate < $actualDate) {
                    $_SESSION['error'] = $this->errorsMessages->getError("date:lessActual");
                    $fail = true;
                } elseif ($endDate < $startDate) {
                    $_SESSION['error'] = $this->errorsMessages->getError("date:EndLessStart");
                    $fail = true;
                }
                if (!$fail) {
                    $res = $this->taskRepo->save($_POST['name'], date("Y-m-d", strtotime($_POST['finicio'])), date("Y-m-d", strtotime($_POST['ffin'])), "pendiente", $_POST['desc'], intval($_POST['asigs']));
                    if (!$res) {
                        //TODO: ERROR: Nuevo mensaje
                        $_SESSION['error'] = $this->errorsMessages->getError("email:repeat");
                    }
                }

            } else {
                $_SESSION['error'] = $errors;
            }

        }
        header("Location: /Task");
    }
}