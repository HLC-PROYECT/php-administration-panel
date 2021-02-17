<?php
require '../../respository/PdoCourseRepository.php';
require '../../domain/course/course.php';

use Course\PdoCourseRepository;

//<s$query = new QueryHelper();
$courseRepository = new PdoCourseRepository();

//$course = $courseRepository->getByDni($_SESSION['uid']);

$courseList = $courseRepository->getAllSubject();

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
    <link rel="stylesheet" href="../../resources/styles/style.css">

    <!-- Title Page-->
    <title>Cursos</title>
</head>

<body class="animsition">
    <div class="page-wrapper">
        <?php require '../parts/header-mobile.php' ?>
        <?php require '../parts/aside.php' ?>
        <div class="page-container">

            <?php require '../parts/header-desktop.php' ?>

            <div class="main-content" style="background-color: rgba(133,133,133,0.09)">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- DATA TABLE -->
                                <h3 class="title-5 m-b-35">Cursos</h3>
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        <div class="rs-select2--light rs-select2--md">
                                            <select class="js-select2" name="property">
                                                <option selected="selected">All Properties</option>
                                                <option value="">Option 1</option>
                                                <option value="">Option 2</option>
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
                                        <button class="au-btn-filter">
                                            <i class="zmdi zmdi-filter-list"></i>filters
                                        </button>
                                    </div>
                                    <div class="table-data__tool-right">
                                        <button class="au-btn au-btn-icon au-btn--green au-btn--small"
                                            data-toggle="modal" data-target="#addTask">
                                            <i class="zmdi zmdi-plus"></i>añadir tarea
                                        </button>
                                    </div>
                                </div>
                                <!-- tabla -->
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2">
                                        <thead>
                                            <tr>
                                                <th>Código de curso</th>
                                                <th>Centro academico</th>
                                                <th>Año inicio</th>
                                                <th>Año fin</th>
                                                <th>Descripción</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <?php
                                    foreach ($courseList as $value) {

                                            echo '<tr class="tr-shadow">';
                                            echo '<td>' . $value->getTask()->getNombre() . '</td>';
                                            echo '<td>' . $value->getTask()->getDescripcion() . '</td>';
                                            echo '<td>' . $value->getTask()->getFInicio() . '</td>';
                                            echo '<td>' . $value->getTask()->getFFin() . '</td>';
                                            $es = $value->getTask()->getEstado();
                                            if ($es == "completada") {
                                                echo '<td> <span class="status--process">' . $es . '</span></td>';
                                            } else {
                                                echo '<td> <span class="status--denied">' . $es . '</span></td>';
                                            }
                                            echo '<td>' . $value->getSubject()->getNombre() . '</td>';
                                            ?>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                    title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
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
            <!--Modal-->
            <?php require 'addCourseModal.php' ?>
        </div>
    </div>
    <?php include '../parts/js.php' ?>
    <script>
    const activeTab = '<?= $activeTab ?? "tarea" ?>';
    </script>
    <script src="../../resources/js/app.js"></script>
</body>

</html>