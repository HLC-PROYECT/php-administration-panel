<?php

namespace HLC\AP\Controller\Task;

use DateTime;
use Exception;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Utils\ErrorsMessages;

class TaskController
{
    protected ?User $user;
    //TODO():Refactor to tasksSubject
    /** @var Subject[] */
    protected array $subjectsTeacher = [];
    /** @var Subject[] */
    protected array $subjects = [];
    protected array $subjectNames = [];
    /** @var string[] */
    private array $errors = [];
    public const TASK_HEADERS = [
        "Task ID",
        "Name",
        "Description",
        "Start Date",
        "End Date",
        "Status",
        "Subject"
    ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SubjectRepositoryInterface $subjectRepository,
        private TaskRepositoryInterface $taskRepository
    )
    {
    }

    public function execute(): string
    {
        $this->user = $this->userRepository->getByDni($_SESSION['uid']);
        if ($this->user->getType() == "P") $this->subjectsTeacher = $this->subjectRepository->getByTeacherId($this->user->getIdentificationDocument());
        //Alumno
        else $this->subjectsTeacher = $this->subjectRepository->getByStudentId($this->user->getIdentificationDocument());

        $this->subjects = $this->subjectRepository->get();

        foreach ($this->subjects as $s) {
            if ($s->getIdentificationDocumentTeacher() === $this->user->getIdentificationDocument()) {
                array_push($this->subjectNames, $s);
            }
        }

        return require __DIR__ . '/../../Views/Task/Task.php';
    }

    public function save(): string
    {
        if (empty(trim($_POST["name"])) || empty(trim($_POST['desc']))) {
            array_push($this->errors, ErrorsMessages::getError("generic:emptyFields"));
        }

        if (empty(trim($_POST["subjectId"])) || trim($_POST["subjectId"]) === '0') {
            array_push($this->errors, ErrorsMessages::getError("generic:emptyFields"));
        }

        if (empty(trim($_POST["endDate"])) || empty(trim($_POST['startDate']))) {
            array_push($this->errors, ErrorsMessages::getError("generic:emptyFields"));
        } else {
            $this->validateDates();
        }

        if (true === empty($this->errors)) {
            if (isset($_POST["taskId"])) $taskId = $_POST["taskId"];
            else $taskId = 0;
            try {
                $this->taskRepository->save(Task::build(
                    $taskId,
                    $_POST['name'],
                    $_POST['desc'],
                    date("Y-m-d", strtotime($_POST['startDate'])),
                    date("Y-m-d", strtotime($_POST['endDate'])),
                    "pendiente",
                    intval($_POST['subjectId'])
                ));

            } catch (Exception $e) {
                array_push($this->errors, ErrorsMessages::getError((string)$e->getCode()));
            }
        }

        return $this->execute();
    }

    private function validateDates(): void
    {
        $date = new DateTime();

        $actualDate = $date->getTimestamp();
        $endDate = strtotime($_POST['endDate']);
        $startDate = strtotime($_POST['startDate']);

        if ($endDate < $actualDate) {
            array_push($this->errors, ErrorsMessages::getError("date:lessActual"));
        }
        if ($endDate < $startDate) {
            array_push($this->errors, ErrorsMessages::getError("date:EndLessStart"));
        }
    }

    public function delete()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['taskId'])
        ) {
            $taskId = $_POST['taskId'];
            $this->taskRepository->deleteById($taskId);

        }
        $this->execute();
    }

    public function fetch()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['taskId'])
        ) {
            $task = $this->taskRepository->getById($_POST['taskId']);

            print(json_encode(
                [
                    'taskId' => $task->getTaskId(),
                    'name' => $task->getName(),
                    'startDate' => $task->getDateStart(),
                    'endDate' => $task->getDateEnd(),
                    'description' => $task->getDescription(),
                    'subjectId' => $task->getSubjectId()
                ]
            ));
        }
    }

    public function send()
    {
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST'
            && isset($_POST['taskId'])
        ) {

            if (!$this->taskRepository->send($_SESSION['uid'], $_POST['taskId'])) {
                array_push($this->errors, ErrorsMessages::getError("task:SendTask"));
            }

        }
    }
}