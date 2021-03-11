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

    public function execute(): string
    {
        $user = $this->userRepository->getByDni($_SESSION['uid']);
        $this->subjects = $this->subjectRepository->get();
        $this->courses = $this->courseRepository->get();
        $this->teachers = $this->userRepository->getTeachers();
        return require __DIR__ . '/../../Views/Subject/Subject.php';
    }

    public function save(): string
    {

        //TODO(): Validar datos de entrada
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
        return $this->execute();
    }

    public function update(): string
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

        $this->subjectRepository->update($subject);
        return $this->execute();
    }


    public function delete(): string
    {
        $subjectId = $_POST["id"];

        $this->subjectRepository->deleteById($subjectId);

        return $this->execute();
    }
}