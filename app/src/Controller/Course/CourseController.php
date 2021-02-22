<?php


namespace HLC\AP\Controller\Course;


use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Repository\PdoUserRepository;


class CourseController
{
    public function __construct(
        private PdoUserRepository $userRepository,
        private PdoCourseRepository $courseRepository,
    ) {
    }


    public function execute(): string
    {
        $currentUserID = $_SESSION['uid'];
        $user = $this->userRepository->getByDni($currentUserID);
        $courseList = $this->courseRepository->getAllCourses($currentUserID);
        return require __DIR__ . '/../../views/course/course.php';
    }


}