<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="home">
    <meta name="author" content="HLC TEAM">
    <meta name="keywords" content="home">
    <link rel="stylesheet" href="resources/styles/style.css">
    <link href="resources/toastr/toastr.css" rel="stylesheet"/>
    <!-- Title Page-->
    <title>Home</title>
</head>

<body class="animsition">

<div class="page-wrapper">
    <?php use HLC\AP\Domain\TaskSubject\TaskSubject;

    require '../src/views/parts/header-mobile.php' ?>
    <?php require '../src/views/parts/aside.php' ?>

    <div class="page-container">

        <?php require '../src/views/parts/header-desktop.php' ?>
        <div class="main-content" style="background-color: rgba(133,133,133,0.09)">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <h3 class="title-5 m-b-35">Tareas</h3>
                            <div class="table-data__tool">
                                <?php

                                if ($task != null) {
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
                            if ($task != null) {
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

                                        foreach ($task as $k => $value) {
                                            if ($value instanceof TaskSubject) {
                                                echo '<tr class="tr-shadow">';
                                                echo '<td>' . $value->getTask()->getName() . '</td>';
                                                echo '<td>' . $value->getTask()->getDescription() . '</td>';
                                                echo '<td>' . $value->getTask()->getDateStart() . '</td>';
                                                echo '<td>' . $value->getTask()->getDateEnd() . '</td>';
                                                if ($user->getType() == 'P') {
                                                    $es = $value->getTask()->getStatus(true);
                                                } else {
                                                    $es = $value->getTask()->getStatus(false);
                                                }
                                                if ($es == "finalizada") {
                                                    echo '<td> <span class="status--process">' . $es . '</span></td>';
                                                } else {
                                                    echo '<td> <span class="status--denied">' . $es . '</span></td>';
                                                }
                                                echo '<td>' . $value->getSubject()->getName() . '</td>';
                                                $id = $value->getTask()->getTaskId();
                                                ?>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <?php
                                                        if ($user->getType() == 'A') {
                                                        //TODO: BOTONES
                                                        ?>
                                                        <button class="item" data-toggle="tooltip"
                                                                data-placement="top"
                                                                title="Send"
                                                                name="po" onclick="send()"
                                                                value="<?php echo $id ?>">
                                                            <i class="zmdi zmdi-mail-send"></i>
                                                            <p id="demo"></p>
                                                            <?php
                                                            }else {

                                                            ?>
                                                            <button class="item" data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Delete"
                                                                    name="po" onclick="loadDoc()"
                                                                    value="<?php echo $id ?>">
                                                                <i class="zmdi zmdi-delete"></i>
                                                                <p id="demo"></p>
                                                                <?php
                                                                }
                                                                ?>
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
        <?php require '../src/views/task/addTaskModal.php' ?>
    </div>
</div>
<script src="resources/toastr/jquery-3.5.1.min.js"></script>
<script src="resources/toastr/toastr.min.js"></script>
<script src="resources/js/authErrorController.js"></script>
<?php include '../src/views/parts/js.php' ?>

<?php
foreach ($this->errors as $value) {
    echo $value;
    echo '<script type="text/javascript">',
        'showError("' . $value . '");',
    '</script>';
}
?>

<script src="resources/js/app.js"></script>
</body>
</html>

