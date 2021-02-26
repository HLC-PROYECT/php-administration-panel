<?php

namespace HLC\AP\Controller\Course;

use DateTime;
use HLC\AP\Domain\Course\Course;
use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Repository\PdoCourseTeacherRepository;
use HLC\AP\Repository\PdoUserRepository;


class CourseController
{
    private string $educationCenter;
    private string $startYear;
    private int $endYear;
    private string $description;
    /** @var string[] $errors */
    private array $errors = [];

    public function __construct(
        private PdoUserRepository $userRepository,
        private PdoCourseRepository $courseRepository,
        private PdoCourseTeacherRepository $courseTeacherRepository
    ) {}

    public function execute(): string
    {

        //Check if the user wants delete a Course.
        if ($this->saveCourse()) {
            $this->validateFields();
            if (empty($this->errors)) {
                $this->insertCourse();
            }
            unset($_POST['saveCourse']);
        }

        $tableHeaders =
            [
                "Course ID",
                "Education Center",
                "Start year",
                "End year",
                "Description"
            ];

        $currentUserID = $_SESSION['uid'];
        $user = $this->userRepository->getByDni($currentUserID);
        $result = $this->courseRepository->getAllCourses($currentUserID);
        $courses = [];
        foreach ($result as $c) {
            if ($c instanceof Course) {
                //Do subquery
                $course = array(
                    $c->getCourseId(),
                    $c->getEducationCenter(),
                    $c->getYearStart(),
                    $c->getYearEnd(),
                    $c->getDescription(),
                );
                array_push($courses, $course);
            }
        }
        //Render a Course view.
        return require __DIR__ . '/../../Views/Course/Course.php';
    }

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
        $date = new DateTime();
        $actualDate = $date->getTimestamp();
        $year = date('Y', $actualDate);

        if (empty($_POST["endYear"]) || empty($_POST["startYear"])) {
            array_push($this->errors, ErrorsMessages::getError("yearEmpty:invalid"));
            return;
        }

        if ($_POST["endYear"] < $year || $_POST["endYear"] > 2050 ||
            $_POST["startYear"] < 2000 || $_POST["startYear"] > 2050) {
            array_push($this->errors, ErrorsMessages::getError("year:invalid"));
            return;
        }

        if ($_POST["startYear"] > $_POST["endYear"]) {
            array_push($this->errors, ErrorsMessages::getError("yearStart:invalid"));
            return;
        }

        $this->endYear = (int)self::sanitize($_POST["endYear"]);
        $this->startYear = (int)self::sanitize($_POST["startYear"]);
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

    public function insertCourse(): void
    {
        $this->courseRepository->insert(
            0,
            $this->educationCenter,
            $this->startYear,
            $this->endYear,
            $this->description
        );
        $courseId = $this->courseRepository->getLastCourseInserted();
        $teacherID = $_SESSION['uid'];
        $this->courseTeacherRepository->insertCourseTeacher($courseId, $teacherID);
    }

    public function saveCourse(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveCourse']);
    }

    public function validateFields(): void
    {
        $this->validateEducationCenter();
        $this->validateDescription();
        $this->validateYear();
    }

    private function deleteCourse(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteCourse']) && isset($_POST['courseId']);
    }

}