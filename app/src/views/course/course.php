<?php
require '../../Utils/DatabaseConnection.php';
require '../../Utils/Medoo.php';
require '../../Domain/Course/CourseRepositoryInterface.php';
require '../../Domain/Course/Course.php';
require '../../Repository/PdoCourseRepository.php';

require '../../Domain/User/UserDataSourceInterface.php';
require '../../Domain/User/User.php';
require '../../Repository/PdoUserRepository.php';

use Course\Course;
use User\PdoUserRepository;
use Course\PdoCourseRepository;

session_start();
$userQ = new PdoUserRepository();
//Get current User to show information in header
$user = $userQ->getByDni($_SESSION['uid']);
$courseRepository = new PdoCourseRepository();
$courseList = $courseRepository->getAllCourses();
session_write_close();
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
    <link rel="stylesheet" href="../../../public/resources/styles/style.css">

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
                                        <span class="dropdown-header">Ordenar por</span>
                                        <select class="js-select2" name="property">
                                            <option selected="selected" value="">Código de curso</option>
                                            <option value="">Año inicio</option>
                                            <option value="">Año fin</option>
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
                                        <i class="zmdi zmdi-plus"></i>añadir curso
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
                                    foreach ($courseList as $key => $value) {
                                        if ($value instanceof Course) {
                                            echo '<tr class="tr-shadow">';
                                            echo '<td>' . $value->getCodCurso() . '</td>';
                                            echo '<td>' . $value->getCentro() . '</td>';
                                            echo '<td>' . $value->getAñoIni() . '</td>';
                                            echo '<td>' . $value->getAñoFin() . '</td>';
                                            echo '<td>' . $value->getDescripcion() . '</td>';
                                            /*
                                            if ($es == "completada") {
                                                echo '<td> <span class="status--process">' . $es . '</span></td>';
                                            } else {
                                                echo '<td> <span class="status--denied">' . $es . '</span></td>';
                                            }*/
                                        }
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
<script src="../../../public/resources/js/app.js"></script>
</body>

</html>