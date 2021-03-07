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
                                            'onclick' => 'remove',
                                            'iconClass' => 'zmdi-delete'
                                        ],
                                        [
                                            'title' => 'Edit',
                                            'onclick' => 'edit',
                                            'iconClass' => 'zmdi-edit'
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

<?php require __DIR__ . '/../Parts/Js.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php
        foreach ($this->errors as $value) {
            echo 'showError("' . $value . '");';
        }
        ?>
    })

    function onSelectorOrder(selector) {

        $.ajax({
            url: "/course/orderBy",
            type: "post",
            data: {
                orderBy: selector.value
            },
            success() {
                window.location.reload();
            }
        });
    }

    function edit(courseId) {
        $.ajax({
            url: "/course/fetchCourse",
            type: "post",
            data: {
                courseId: courseId
            },
            success(response) {
                console.log(response);
                response = response.substring(response.indexOf('{'), response.indexOf('}') + 1);
                response = JSON.parse(response);
                document.getElementById('addCourseLabel').innerHTML = 'Edit course';
                document.getElementById('form_educationCenter').value = response.educationCenter;
                document.getElementById('form_startYear').value = response.startYear;
                document.getElementById('form_endYear').value = response.endYear;
                document.getElementById('form_description').value = response.description;
                document.getElementById('form_courseId').value = response.courseId;
                //Open modal
                $('#addTask').modal('show');
            }
        });
    }

    function remove(courseId) {
        createForm("courseId", courseId, "/course/delete")
    }

    function createForm(name, value, url) {
        form = document.createElement('form');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', url);
        courseField = document.createElement('input');
        courseField.setAttribute('name', name);
        courseField.setAttribute('type', 'hidden');
        courseField.setAttribute('value', value);
        form.appendChild(courseField);
        document.body.appendChild(form);
        form.submit();
    }

</script>

</body>

</html>
