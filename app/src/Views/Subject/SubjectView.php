<?php

use HLC\AP\Controller\Subject\SubjectController;
use HLC\AP\Views\Helpers\componentsHelper;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="subject">
    <meta name="author" content="HLC TEAM">
    <meta name="keywords" content="subject">
    <link rel="stylesheet" href="/resources/styles/style.css">
    <title>Subject</title>
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
                            <h3 class="title-5 m-b-35">Subject</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--md">
                                        <?php
                                        if (!empty($this->subjects)) {
                                            ?>
                                            <div class="rs-select2--light rs-select2--md">
                                                <label for="orderBy" class="dropdown-header">Order by</label>
                                                <select onchange="onSelectorOrder(this)" class="js-select2" id="orderBy"
                                                        name="property">
                                                    <option <?php echo $_SESSION['subjectOrder'] === 'subjectId' ? 'selected="selected"' : ''; ?>
                                                            value="subjectId">Subject ID
                                                    </option>
                                                    <option <?php echo $_SESSION['subjectOrder'] === 'name' ? 'selected="selected"' : ''; ?>
                                                            value="name">Name
                                                    </option>
                                                    <option <?php echo $_SESSION['subjectOrder'] === 'num_hours' ? 'selected="selected"' : ''; ?>
                                                            value="num_hours">Num Hours
                                                    </option>
                                                    <option <?php echo $_SESSION['subjectOrder'] === 'courseId' ? 'selected="selected"' : ''; ?>
                                                            value="courseId">Course ID
                                                    </option>
                                                </select>
                                                <div class="dropDownSelect2"></div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small"
                                            data-toggle="modal" data-target="#addSubject">
                                        <i class="zmdi zmdi-plus"></i>ADD SUBJECT
                                    </button>
                                </div>
                            </div>
                            <!-- tabla -->
                            <div class="table-responsive table-responsive-data2">
                                <div class='alert alert-info' id="coursesNotFound" style="display: none;" role='alert'>
                                    No subjects to display.
                                </div>
                                <?=
                                empty($this->subjects) ?
                                    ComponentsHelper::emptyViewBuilder('subjects', 'warning') :
                                    ComponentsHelper::tableBuilder(
                                        SubjectController::SUBJECT_HEADERS,
                                        $this->subjects,
                                        [
                                            'getId',
                                            'getName',
                                            'getCourseDescription',
                                            'getNumHours',
                                            'getTeacherName'
                                        ],
                                        [
                                            [
                                                'title' => 'delete',
                                                'onclick' => '',
                                                'iconClass' => 'zmdi-delete',
                                                'formAction' => 'subject/delete'
                                            ],
                                            [
                                                'title' => 'Edit',
                                                'onclick' => 'edit',
                                                'iconClass' => 'zmdi-edit',
                                                'name' => 'edit'
                                            ],
                                            [
                                                'title' => 'Add task',
                                                'onclick' => 'addTask',
                                                'iconClass' => 'zmdi-plus',
                                                'name' => 'addTask'
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
        <?php require __DIR__ . '/AddSubjectModal.php' ?>
        <?php require __DIR__ . '/../Task/AddTaskModal.php' ?>
    </div>
</div>
<?php include __DIR__ . '/../Parts/Js.php' ?>
<script src="/resources/js/subjects.js"></script>
</body>

</html>
