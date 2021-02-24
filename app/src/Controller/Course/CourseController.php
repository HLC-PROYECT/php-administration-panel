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
        return require __DIR__ . '/../../Views/course/course.php';
    }


}