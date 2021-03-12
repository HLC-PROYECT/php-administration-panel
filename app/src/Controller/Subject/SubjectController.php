<?php

namespace HLC\AP\Controller\Subject;

use HLC\AP\Domain\Course\Course;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\Subject\Subject;
use HLC\AP\Domain\Subject\SubjectRepositoryInterface;
use HLC\AP\Domain\User\User;
use HLC\AP\Domain\User\UserRepositoryInterface;

class SubjectController
{
    /** @var Subject[] $subjects */
    protected array $subjects;
    /** @var Course[] $courses */
    protected array $courses;
    /** @var User[] $teachers */
    protected array $teachers;
    public const SUBJECT_HEADERS = [
        "Id",
        "Name",
        "Course",
        "Number of hours",
        "Teacher"
    ];

    public function __construct(
        private UserRepositoryInterface $userRepository,
        private SubjectRepositoryInterface $subjectRepository,
        private CourseRepositoryInterface $courseRepository,
    ) {
    }

    public function execute(): void
    {
        $this->user = $this->userRepository->getByDni($_SESSION['uid']);
        $this->subjects = $this->subjectRepository->get();
        $this->courses = $this->courseRepository->getCoursesById($this->user->getIdentificationDocument());
        $this->teachers = $this->userRepository->getTeachers();

        require __DIR__ . '/../../Views/Subject/Subject.php';
        set_url("subject");
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
}