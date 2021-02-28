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
    <link href="/resources/toastr/toastr.css" rel="stylesheet"/>
    <!-- Title Page-->
    <title>Home</title>
</head>

<body class="animsition">

<div class="page-wrapper">
    <?php

    use HLC\AP\Domain\Task\Task;

    require __DIR__ . '/../Parts/HeaderMobile.php';
    require __DIR__ . '/../Parts/Aside.php';
    ?>

    <div class="page-container">

        <?php require __DIR__ . '/../Parts/HeaderDesktop.php' ?>
        <div class="main-content" style="background-color: rgba(133,133,133,0.09)">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- DATA TABLE -->
                            <h3 class="title-5 m-b-35">Tareas</h3>
                            <div class="table-data__tool">
                                <?php

                                if (false === empty($this->subjectsTeacher)) {
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
                            if (false === empty($this->subjectsTeacher)) {
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

                                        foreach ($this->subjectsTeacher as $subject) {
                                            /** @var Task $task */
                                            foreach ($subject->getTasks() as $task) {
                                                echo '<tr class="tr-shadow">';
                                                echo '<td>' . $task->getName() . '</td>';
                                                echo '<td>' . $task->getDescription() . '</td>';
                                                echo '<td>' . $task->getDateStart() . '</td>';
                                                echo '<td>' . $task->getDateEnd() . '</td>';
                                                $es = $task->status($this->user->getType() === 'P');
                                                echo '<td> <span class="status--'.
                                                    ($es == "finalizada" ? "process" : "denied") .
                                                    '">' . $es . '</span></td>';

                                                echo '<td>' . $subject->getName() . '</td>';

                                                $id = $task->getTaskId();
                                                ?>
                                                <td>
                                                    <div class="table-data-feature">
                                                        <?php
                                                        if ($this->user->getType() == 'A') {
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
        <?php require  __DIR__ . '/AddTaskModal.php' ?>
    </div>
</div>
<?php include  __DIR__ . '/../Parts/Js.php' ?>

</body>
</html>
