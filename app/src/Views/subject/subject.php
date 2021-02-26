<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="subject">
    <meta name="author" content="HLC TEAM">
    <meta name="keywords" content="subject">
    <link rel="stylesheet" href="resources/styles/style.css">
    <title>Subject</title>
</head>

<body class="animsition">
<div class="page-wrapper">
    <?php require '../src/Views/parts/header-mobile.php' ?>
    <?php require '../src/Views/parts/aside.php' ?>
    <div class="page-container">

        <?php require '../src/Views/parts/header-desktop.php' ?>

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
                                <table class="table table-data2">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Course</th>
                                        <th>Number of hours</th>
                                        <th>Teacher</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <?php
                                    foreach ($this->subjects as $subject) {
                                        echo '<tr class="tr-shadow">';
                                        echo '<td>' . $subject->getName() . '</td>';
                                        echo '<td>' . $subject->getCourseName() . '</td>';
                                        echo '<td>' . $subject->getNumHours() . '</td>';
                                        echo '<td>' . $subject->getTeacherName() . '</td>';
                                        ?>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-id="<?=$subject->getId()?>"
                                                        title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                                <button class="item"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-id="<?=$subject->getId()?>"
                                                        title="modify">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                                <button class="item"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        data-id="<?=$subject->getId()?>"
                                                        title="addTask">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </div>
                                        </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                        <?php
                                    }
                                    ?>

                                </table>
                            </div>
                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require __DIR__ . '/addSubjectModal.php' ?>
    </div>
</div>
<?php include '../src/Views/parts/js.php' ?>
<script>
    const activeTab = '<?= $activeTab ?? "subject" ?>';
</script>
</body>

</html>
