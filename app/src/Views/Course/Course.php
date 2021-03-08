<?php

use HLC\AP\Controller\Course\CourseController;
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
                                    <div class="rs-select2--light rs-select2--md">
                                        <label for="order" class="dropdown-header">Order by</label>
                                        <select class="js-select2" id="order" name="property">
                                            <option selected="selected" value="">Course ID</option>
                                            <option value="">Start Date</option>
                                            <option value="">End Date</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <div class="rs-select2--light rs-select2--sm">
                                        <select class="js-select2" name="time">
                                            <option selected="selected">Today</option>
                                            <option value="">3 Days</option>
                                            <option value="">1 Week</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small"
                                            data-toggle="modal" data-target="#addTask">
                                        <i class="zmdi zmdi-plus"></i>Add Course
                                    </button>
                                </div>
                            </div>
                            <!-- tabla -->
                            <div class="table-responsive table-responsive-data2">
                                <?=
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
                                    [
                                        [
                                            'title' => 'Delete',
                                            'onclick' => 'delete',
                                            'iconClass' => 'zmdi-delete'
                                        ]
                                    ]
                                );
                                ?>
                            </div>
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <?php require __DIR__ . '/AddCourseModal.php' ?>
    </div>
</div>

<?php
require __DIR__ . '/../Parts/Js.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php
        foreach ($this->errors as $value) {
            echo 'showError("' . $value . '");';
        }
        ?>
    })

    function remove(courseId) {
        console.log(courseId);
        $.ajax({
            url: "/course/delete",  //the page containing php script
            type: "post",    //request type,
            data: {
                deleteCourse: true,
                courseId: courseId
            },
            success() {
                console.log('Curso eliminado');
            }
        });
    }
</script>

</body>

</html>
