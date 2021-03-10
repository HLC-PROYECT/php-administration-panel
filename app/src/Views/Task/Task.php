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
    $addTaskButton =
        '<div class="table-data__tool-right">
            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal"
                    data-target="#addTask">
                <i class="zmdi zmdi-plus"></i>add task
            </button>
        </div>';
    $isTeacher = true;
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
    $addTaskButton = '';
    $isTeacher = false;
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
    <title>Task</title>
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
                            <h3 class="title-5 m-b-35">Tasks</h3>
                            <div class="table-data__tool">
                                <?php

                                if (false === empty($this->subjectsTeacher)) {
                                    ?>
                                    <div class="table-data__tool-left">
                                        <div class="rs-select2--light rs-select2--md">
                                            <select onchange="onSelectorFilter(this)"
                                                    class="js-select2"
                                                    name="property"
                                                    id="orderBy">

                                                <option
                                                    <?php echo $_SESSION['taskFilter'] === 'all' ?
                                                        'selected="selected"' : ''; ?>
                                                        value="all">
                                                    All Properties
                                                </option>

                                                <option
                                                    <?php echo $_SESSION['taskFilter'] === 'completed' ?
                                                        'selected="selected"' : ''; ?>
                                                        value="completed">
                                                    Completed
                                                </option>

                                                <option
                                                    <?php echo $_SESSION['taskFilter'] === 'pending' ?
                                                        'selected="selected"' : ''; ?>
                                                        value="pending">
                                                    Pending
                                                </option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>

                                <?= $addTaskButton ?>
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
                                    $buttons,
                                    $isTeacher
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
<script src="/resources/js/task.js"></script>
<script>
    /*
     function onSelectorFilter(selector) {

         $.ajax({
             url: "/task/orderBy",
             type: "post",
             data: {
                 filterBy: selector.value
             },
             success() {
                 window.location.reload();
             }
         });
     }
*/
</script>
</body>
</html>
