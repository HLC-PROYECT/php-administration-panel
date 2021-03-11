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
                                        <span class="dropdown-header">Filter</span>
                                        <select class="js-select2" name="property">
                                            <!-- TODO: Selector por cursos existentes y activos -->
                                            <option selected="selected" value="">Subject</option>
                                            <option value="">Año inicio</option>
                                            <option value="">Año fin</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <div class="rs-select2--light rs-select2--sm">
                                        <!-- TODO: Filtrar por profesor -->
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
                                        <i class="zmdi zmdi-plus"></i>ADD SUBJECT
                                    </button>
                                </div>
                            </div>
                            <!-- tabla -->
                            <div class="table-responsive table-responsive-data2">
                                <?=
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
                                                'title' => 'edit',
                                                'onclick' => '',
                                                'iconClass' => 'zmdi-edit',
                                                'formAction' => 'subject/update'
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
    </div>
</div>
<?php include __DIR__ . '/../Parts/Js.php' ?>
</body>

</html>
