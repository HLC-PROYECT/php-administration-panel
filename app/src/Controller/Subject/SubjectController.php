<?php

namespace HLC\AP\Controller\Subject;

use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;

class SubjectController
{
    public const SUBJECT_HEADERS = [
        "Id",
        "Name",
        "Course",
        "Number of hours",
        "Teacher"
    ];

    public const SUBJECT_BUTTONS = [
        [
            'title' => 'delete',
            'onclick' => '',
            'iconClass' => 'zmdi-delete',
            'formAction' => 'subject/delete'
        ],
        [
            'title' => 'Edit',
            'onclick' => 'edit',
            'iconClass' => 'zmdi-edit',
            'name' => 'edit'
        ],
        [
            'title' => 'Add task',
            'onclick' => 'addTask',
            'iconClass' => 'zmdi-plus',
            'name' => 'addTask'
        ]
    ];

    protected ?User $user;
    /** @var string[] */
    protected array $errors = [];
    /** @var Subject[] $subjects */
    protected array $subjects;
    /** @var Course[] $courses */
    protected array $courses;
    /** @var User[] $teachers */
    protected array $teachers;
    /** @var Subject[] */
    protected array $subjectNames;

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SubjectRepositoryInterface $subjectRepository,
        private CourseRepositoryInterface $courseRepository,
    )
    {
        if (!isset($_SESSION['subjectOrder'])) {
            $_SESSION['subjectOrder'] = 'subjectId';
        }
    }

    public function execute(): void
    {
        if (!isset($_SESSION['uid'])) header("Location: /");

        $this->user = $this->userRepository->getByDni($_SESSION['uid']);
        if ($this->user->getType() === 'P') {
            $this->querySubjectsByOrder($this->user->getIdentificationDocument(), $_SESSION['subjectOrder']);
        } else {
            $this->queryStudentSubjectsByOrder($this->user->getIdentificationDocument(), $_SESSION['subjectOrder']);
        }
        $this->subjectNames = $this->subjects;
        $this->courses = $this->courseRepository->getCoursesById($this->user->getIdentificationDocument());
        $this->teachers = $this->userRepository->getTeachers();

        require __DIR__ . '/../../Views/Subject/SubjectView.php';
        set_url('Subject');
    }

    public function orderBy(): void
    {
        $_SESSION['subjectOrder'] = $_POST['orderBy'];
        $this->execute();
    }

    public function save(): void
    {
        $name = $_POST["name"];
        $nHours = (int)$_POST["nHours"];
        $endingYear = (int)$_POST["endingYear"];
        $course = (int)$_POST["course"];
        $teacher = $_POST["teacher"];

        $subject = Subject::build(
            0,
            $name,
            $nHours,
            $endingYear,
            Course::build(
                $course,
                "",
                0,
                0,
                ""
            ),
            User::build(
                $teacher,
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "P"
            )
        );

        $this->subjectRepository->save($subject);
        $this->execute();
    }

    public function update(): void
    {
        $subjectId = $_POST["id"];
        $name = $_POST["name"];
        $nHours = (int)$_POST["nHours"];
        $endingYear = (int)$_POST["endingYear"];
        $course = (int)$_POST["course"];
        $teacher = $_POST["teacher"];

        $subject = Subject::build(
            $subjectId,
            $name,
            $nHours,
            $endingYear,
            Course::build(
                $course,
                "",
                0,
                0,
                ""
            ),
            User::build(
                $teacher,
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "P"
            )
        );

        $this->subjectRepository->update($subject);
        $this->execute();
    }

    public function delete(): void
    {
        $subjectId = $_POST["id"];

        $this->subjectRepository->deleteById($subjectId);

        $this->execute();
    }

    private function querySubjectsByOrder(string $tearcherId, string $order = 'codasig'): void
    {
        $this->subjects = match ($order) {
            'num_hours' => $this->subjectRepository->getTeacherSubjectOrderByNumHours($tearcherId),
            'name' => $this->subjectRepository->getTeacherSubjectOrderByName($tearcherId),
            'courseId' => $this->subjectRepository->getTeacherSubjectOrderByCourseId($tearcherId),
            default => $this->subjectRepository->getTeacherSubjectOrderByID($tearcherId),
        };
    }

    private function queryStudentSubjectsByOrder(string $studentId, string $order = 'codasig')
    {
        $this->subjects = match ($order) {
            'num_hours' => $this->subjectRepository->getStudentSubjectOrderByNumHours($studentId),
            'name' => $this->subjectRepository->getStudentSubjectOrderByName($studentId),
            'courseId' => $this->subjectRepository->getStudentSubjectOrderByCourseId($studentId),
            default => $this->subjectRepository->getstu($studentId),
        };
    }
}