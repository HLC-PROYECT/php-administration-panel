<?php

namespace HLC\AP\Controller\Course\CourseInsert;

use Exception;
use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Repository\PdoCourseTeacherRepository;

use HLC\AP\Utils\ErrorsMessages;

class CourseInsertController
{
    private string $educationCenter;
    private string $startYear;
    private string $endYear;
    private string $description;
    /** @var string[] $errors */
    private array $errors;
    
    public function __construct(
        private ErrorsMessages $errorsMessages,
        private PdoCourseRepository $courseRepository,
        private PdoCourseTeacherRepository $courseTeacherRepository,
    ) {}

    private function validateEducationCenter(): void
    {
        if (empty($_POST["educationCenter"]) || strlen($_POST["educationCenter"]) < 4) {
            array_push($this->errors, ErrorsMessages::getError("educationCenter:invalid"));
            return;
        }
        $this->educationCenter = self::sanitize($_POST["educationCenter"]);
    }

    private function validateYear(): void
    {
        if (empty($_POST["endYear"]) || empty($_POST["startYear"])) {
            array_push($this->errors, ErrorsMessages::getError("year:invalid"));
            return;
        }else if(strlen($_POST["endYear"]) < 4 || strlen($_POST["startYear"]) < 4) {
            array_push($this->errors, ErrorsMessages::getError("yearLenght:invalid"));
            return;
        }else if($_POST["endYear"] < 2000 || $_POST["endYear"] > 2050 || 
                 $_POST["startYear"] < 2000 || $_POST["startYear"] > 2050  ){
                array_push($this->errors, ErrorsMessages::getError("year:invalid"));
                return;
        }else if($_POST["startYear"] > $_POST["endYear"]) {
            array_push($this->errors, ErrorsMessages::getError("yearStart:invalid"));
            return;
        }
        $this->endYear = (int) self::sanitize($_POST["endYear"]);
        $this->startYear = (int) self::sanitize($_POST["startYear"]);

    }

    private function validateDescription(): void
    {
        if (empty($_POST["description"]) || strlen($_POST["description"]) < 4) {
            array_push($this->errors, ErrorsMessages::getError("description:invalid"));
            return;
        }
        $this->description = self::sanitize($_POST["description"]);
    }

    private static function sanitize(string $data): string
    {
        $data = trim($data); // Delete All spaces before and after the data
        $data = stripslashes($data); // Delete backslashes \
        $data = htmlspecialchars($data); // Translate special characters in HTML entities
        return $data;
    }

    public function execute()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
                $this->validateEducationCenter();
                $this->validateDescription();
                $this->validateYear();
            if (empty($this->$errors)) {
                    $this->courseRepository->insert(
                        0,
                        $this->educationCenter,
                        $this->startYear,
                        $this->endYear,
                        $this->description
                    );
                    // TODO: INSERT TEACHER IN curso_profesor table.
                    // $this->courseTeacherRepository->insertCourseTeacher();
                } else {
                    var_dump($this->$errors);
                $_SESSION['error'] = $this->$errors;
            }
        }

        //header("Location: /Course");
    }



}