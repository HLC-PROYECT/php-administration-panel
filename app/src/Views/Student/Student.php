<?php

use HLC\AP\Controller\Course\CourseController;
use HLC\AP\Controller\Student\StudentController;
use HLC\AP\Views\Helpers\ComponentsHelper;

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
    <title>Students</title>
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
                            <h3 class="title-5 m-b-35">Students</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <?php
                                    if (!empty($this->students)) {
                                        ?>
                                        <div class="rs-select2--light rs-select2--md">
                                            <label for="orderBy" class="dropdown-header">Order by</label>
                                            <select onchange="onSelectorOrder(this)" class="js-select2" id="orderBy"
                                                    name="property">
                                                <option <?php echo $_SESSION['studentOrder'] === 'codcurso' ? 'selected="selected"' : ''; ?>
                                                        value="courseId">Course ID
                                                </option>
                                                <option <?php echo $_SESSION['studentOrder'] === 'nombre' ? 'selected="selected"' : ''; ?>
                                                        value="name">Name
                                                </option>
                                                <option <?php echo $_SESSION['studentOrder'] === 'f_alta' ? 'selected="selected"' : ''; ?>
                                                        value="StartDate">Start Date
                                                </option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- tabla -->

                            <div class="table-responsive table-responsive-data2" id="table-container">
                                <div class='alert alert-info' id="coursesNotFound" style="display: none;" role='alert'>
                                    No students to display.
                                </div>
                                <?=

                                empty($this->students) ?
                                    ComponentsHelper::emptyViewBuilder('students', 'warning') :
                                    ComponentsHelper::tableBuilder(
                                        StudentController::STUDENT_HEADERS,
                                        $this->students,
                                        [
                                            'getIdentificationDocument',
                                            'getEmail',
                                            'getName',
                                            'getDateStart',
                                            'getCourseId',
                                            'getBirthDate',
                                        ],
                                        StudentController::STUDENT_BUTTONS
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
        <?php require __DIR__ . '/AddStudentModal.php' ?>
    </div>
</div>

<script src="/resources/js/student.js"></script>
<?php require __DIR__ . '/../Parts/Js.php'; ?>
</body>
</html>
