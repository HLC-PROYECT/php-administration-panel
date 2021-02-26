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
        $this->courses = $this->courseRepository->getCoursesById();
        $this->teachers = $this->userRepository->getTeachers();
        return require __DIR__ . '/../../Views/Subject/Subject.php';
    }
}