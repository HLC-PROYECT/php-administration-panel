<?php

use HLC\AP\Controller\Task\TaskController;
use HLC\AP\Domain\Task\Task;
use HLC\AP\Views\Helpers\componentsHelper;

if ($this->user->getType() === 'P') {
    $buttons = [
        [
            'title' => 'Edit',
            'onclick' => 'edit',
            'iconClass' => 'zmdi-edit',
            'name' => 'edit'
        ],
        [
            'title' => 'Delete',
            'onclick' => 'remove',
            'iconClass' => 'zmdi-delete',
            'name' => 'delete'
        ],
    ];
    $status = 'getTeacherStatus';
} else {
    $buttons = [
        [
            'title' => 'Send',
            'onclick' => 'send',
            'iconClass' => 'zmdi-mail-send',
            'name' => 'send'
        ],
    ];
    $status = 'getStudentStatus';
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
    <link rel="stylesheet" href="/resources/styles/style.css">
    <link href="/resources/toastr/toastr.css" rel="stylesheet"/>
    <!-- Title Page-->
    <title>Home</title>
</head>

<body class="animsition">

<div class="page-wrapper">
    <?php

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
                            <div class="table-responsive table-responsive-data2">
                                <?=
                                ComponentsHelper::tableBuilderForTasks(
                                    TaskController::TASK_HEADERS,
                                    $this->subjectsTeacher,
                                    [
                                        'getTaskId',
                                        'getName',
                                        'getDescription',
                                        'getDateStart',
                                        'getDateEnd',
                                        $status,
                                        'getName',
                                    ],
                                    $buttons
                                );
                                ?>
                            </div>
                            <!-- END DATA TABLE -->
                            <!--start Spinner-->
                            <div id="richList"></div>


                            <div id="loader" class="lds-dual-ring hidden overlay spinner-box">
                                <div class="configure-border-1">
                                    <div class="configure-core"></div>
                                </div>
                                <div class="configure-border-2">
                                    <div class="configure-core"></div>
                                </div>
                            </div>
                            <!--end spinner-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Modal-->
        <?php require __DIR__ . '/AddTaskModal.php' ?>
    </div>
</div>
<?php include __DIR__ . '/../Parts/Js.php' ?>
<script>
    /*
     function onSelectorOrder(selector) {

         $.ajax({
             url: "/task/orderBy",
             type: "post",
             data: {
                 orderBy: selector.value
             },
             success() {
                 window.location.reload();
             }
         });
     }

     function edit(id) {
         $.ajax({
             url: "/task/fetch",
             type: "post",
             data: {
                 courseId: id
             },
             success(response) {
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
     }*/

    function remove(taskId) {
        $.ajax({
            url: "/task/delete",  //the page containing php script
            type: "post",
            data: {
                taskId: taskId
            },
            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                $('#loader').removeClass('hidden')
            },
            success(response) {
                console.log('ok');
                window.location.reload();
            },
            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                $('#loader').addClass('hidden')
            },
        });
    }

</script>
</body>
</html>
