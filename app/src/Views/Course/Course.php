<?php

use HLC\AP\Controller\Course\CourseController;
use HLC\AP\Views\Helpers\ComponentsHelper;

$buttons = [];
$isTeacher = $this->user->getType() === 'P';
if ($isTeacher) {
    $buttons = CourseCOntroller::COURSE_BUTTONS;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="home">
    <meta name="author" content="HLC TEAM">
    <meta name="keywords" content="home">
    <link rel="stylesheet" href="/resources/styles/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <title>Courses</title>
</head>

<body class="animsition">
<div class="page-wrapper">

    <?php require __DIR__ . '/../Parts/HeaderMobile.php' ?>
    <?php require __DIR__ . '/../Parts/Aside.php' ?>

    <div class="page-container">

        <?php require __DIR__ . '/../Parts/HeaderDesktop.php' ?>

        <div class="main-content" style="background-color: rgba(133,133,133,0.09)">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <h3 class="title-5 m-b-35">Courses</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <?php
                                    if (!empty($this->courses)) {
                                        ?>
                                        <div class="rs-select2--light rs-select2--md">
                                            <label for="orderBy" class="dropdown-header">Order by</label>
                                            <select onchange="onSelectorOrder(this)" class="js-select2" id="orderBy"
                                                    name="property">
                                                <option <?php echo $_SESSION['courseOrder'] === 'codcurso' ? 'selected="selected"' : ''; ?>
                                                        value="courseId">Course ID
                                                </option>
                                                <option <?php echo $_SESSION['courseOrder'] === 'a_inicio' ? 'selected="selected"' : ''; ?>
                                                        value="yearStart">Start Date
                                                </option>
                                                <option <?php echo $_SESSION['courseOrder'] === 'a_fin' ? 'selected="selected"' : ''; ?>
                                                        value="yearEnd">End Date
                                                </option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <div class="table-data__tool-left">
                                    <label for="orderBy" class="dropdown-header">Join to course</label>
                                    <?=
                                    ComponentsHelper::selectorBuilder(
                                        'courses',
                                        'joinCourse',
                                        $this->notJoinedCourses,
                                        [
                                            'getCourseId',
                                            'getDescription'
                                        ]
                                    )
                                    ?>
                                </div>

                                <div class="table-data__tool-right">
                                    <label for="orderBy" class="dropdown-header">&nbsp</label>
                                    <?php
                                    if ($isTeacher) {
                                        ?>
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small"
                                                data-toggle="modal" data-target="#addTask">
                                            <i class="zmdi zmdi-plus"></i>Add Course
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- tabla -->

                            <div class="table-responsive table-responsive-data2" id="table-container">
                                <div class='alert alert-info' id="coursesNotFound" style="display: none;" role='alert'>
                                    No courses to display.
                                </div>
                                <?=

                                empty($this->courses) ?
                                    ComponentsHelper::emptyViewBuilder('courses', 'warning') :
                                    ComponentsHelper::tableBuilder(
                                        CourseController::COURSE_HEADERS,
                                        $this->courses,
                                        [
                                            'getCourseId',
                                            'getEducationCenter',
                                            'getYearStart',
                                            'getYearEnd',
                                            'getDescription',
                                        ],
                                        $buttons
                                    );
                                ?>
                            </div>
                            <!-- END DATA TABLE -->

                            <!--Spinner-->
                            <div id="richList"></div>


                            <div id="loader" class="lds-dual-ring hidden overlay spinner-box">
                                <div class="configure-border-1">
                                    <div class="configure-core"></div>
                                </div>
                                <div class="configure-border-2">
                                    <div class="configure-core"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal-->
        <?php require __DIR__ . '/AddCourseModal.php' ?>
    </div>
</div>

<?php require __DIR__ . '/../Parts/Js.php'; ?>
<script src="/resources/js/course.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php
        foreach ($this->errors as $value) {
            echo 'showError("' . $value . '");';
        }
        ?>
    })
</script>
</body>
</html>
