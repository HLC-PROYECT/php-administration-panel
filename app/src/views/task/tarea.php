<?php

require '../parts/querysRequires.php';

use Medoo\Medoo;
use Subject\PdoSubjectRepository;
use Task\PdoTaskRepository;
use TaskSubject\PdoTaskSubjectRepository;
use User\PdoUserRepository;
use  TaskSubject\taskSubject;

session_start();

$taskSubjectRepo = new PdoTaskSubjectRepository();
$subjectRepo = new PdoSubjectRepository();
$userQ = new PdoUserRepository();
$task = new PdoTaskRepository();
$user = $userQ->getByDni($_SESSION['uid']);
$subjects = $taskSubjectRepo->getTaskSubjectUsingDni("12345678A");
$subjectNames = $subjectRepo->getAllSubject();
//TODO(): OPTIMIZAR BORRADO
function delete(int $id)
{
    $task = new PdoTaskRepository();
    $task->deleteById($id);

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
    <link rel="stylesheet" href="../../../../../../Downloads/php-administration-panel/resources/styles/style.css">
    <link href="../../../../../../Downloads/php-administration-panel/resources/toastr/toastr.css" rel="stylesheet"/>
    <!-- Title Page-->
    <title>Home</title>
</head>

<body class="animsition">
<script src="../../../../../../Downloads/php-administration-panel/resources/toastr/jquery-3.5.1.min.js"></script>
<script src="../../../../../../Downloads/php-administration-panel/resources/toastr/toastr.min.js"></script>
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
                            <h3 class="title-5 m-b-35">Tareas</h3>
                            <div class="table-data__tool">
                                <?php

                                if ($subjects != null) {
                                    ?>
                                    <div class="table-data__tool-left">
                                        <div class="rs-select2--light rs-select2--md">
                                            <select class="js-select2" name="property">
                                                <option selected="selected">All Properties</option>
                                                <option value="">Completed</option>
                                                <option value="">Pending</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <div class="rs-select2--light rs-select2--sm">
                                            <select class="js-select2" name="time">
                                                <option selected="selected">All Time</option>
                                                <option value="">Today</option>
                                                <option value="">1 Week</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <button class="au-btn-filter">
                                            <i class="zmdi zmdi-filter-list"></i>filters
                                        </button>
                                    </div>

                                    <?php
                                }
                                ?>


                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal"
                                            data-target="#addTask">
                                        <i class="zmdi zmdi-plus"></i>añadir tarea
                                    </button>
                                </div>
                            </div>
                            <!-- tabla -->

                            <?php
                            if ($subjects != null) {
                                ?>
                                <div class="table-responsive table-responsive-data2">
                                    <table class="table table-data2">
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>description</th>
                                            <th>Inicio</th>
                                            <th>Fin</th>
                                            <th>Estado</th>
                                            <th>Asignatura</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        foreach ($subjects as $k => $value) {
                                            if ($value instanceof taskSubject) {
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
                                                $id = $value->getTask()->getCodtarea();
                                                ?>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <button class="item" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Delete"
                                                                name="po" onclick="loadDoc()"
                                                                value="<?php echo $id ?>">
                                                        <i class="zmdi zmdi-delete"></i>
                                                        <p id="demo"></p>

                                                        <script>
                                                            function loadDoc() {
                                                                document.getElementById("demo").innerHTML = <?php delete($id) ?>;
                                                                var xhttp = new XMLHttpRequest();
                                                                xhttp.onreadystatechange = function () {
                                                                    if (this.readyState == 4 && this.status == 200) {
                                                                    }
                                                                };
                                                                xhttp.open("POST", "tarea.php", true);
                                                                xhttp.send();

                                                            }
                                                        </script>

                                                    </div>
                                                </td>
                                                </tr>
                                                <tr class="spacer"></tr>
                                                <?php
                                            }
                                        } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- END DATA TABLE -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <?php require 'addTaskModal.php' ?>
    </div>
</div>
<?php include '../parts/js.php' ?>

<script>
    const activeTab = '<?= $activeTab ?? "tarea" ?>';
</script>
<script src="../../../../../../Downloads/php-administration-panel/resources/js/authErrorController.js"></script>

<script src="../../../../../../Downloads/php-administration-panel/resources/js/app.js"></script>
<?php require '../parts/errorToast.php' ?>
</body>
</html>

