<?php


namespace HLC\AP\Controller\Course\CourseInsert;


use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Utils\ErrorsMessages;

class CourseInsertController
{
    public function __construct(
        private ErrorsMessages $errorsMessages,
        private PdoCourseRepository $courseRepository,
    ){

    }

    public function execute(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
            if (empty($errors)) {
               //TODO : VALIDATE FIELDS AND ADD COURSE;
            } else {
                $_SESSION['error'] = $errors;
            }

        }
        header("Location: /Course");
    }
}