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
    <title>Courses</title>
</head>

<body class="animsition">
<div class="page-wrapper">
    <?php
    use HLC\AP\Domain\Course\Course;
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
                            <h3 class="title-5 m-b-35">Courses</h3>
                            <div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--md">
                                        <label for="order" class="dropdown-header">Order by</label>
                                        <select class="js-select2" id="order"  name="property">
                                            <option selected="selected" value="">Course ID</option>
                                            <option value="">Start Date</option>
                                            <option value="">End Date</option>
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
                                        <i class="zmdi zmdi-plus"></i>Add Course
                                    </button>
                                </div>
                            </div>
                            <!-- tabla -->
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2">
                                    <thead>
                                    <tr>
                                        <th>Course ID</th>
                                        <th>Education center</th>
                                        <th>Start year</th>
                                        <th>End year</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <?php
                                    foreach ($courseList as $key => $value) {
                                        //Smart cast
                                        if ($value instanceof Course) {
                                            echo '<tr class="tr-shadow">';
                                            echo '<td>' . $value->getCourseId() . '</td>';
                                            echo '<td>' . $value->getEducationCenter() . '</td>';
                                            echo '<td>' . $value->getYearStart() . '</td>';
                                            echo '<td>' . $value->getYearEnd() . '</td>';
                                            echo '<td>' . $value->getDescription() . '</td>';
                                        }
                                        ?>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="item" data-toggle="tooltip" data-placement="top"
                                                        title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                            </div>
                                        </td>
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
        <?php require '../src/views/course/addCourseModal.php' ?>
    </div>
</div>
<?php include '../src/views/parts/js.php' ?>
<script>
    const activeTab = '<?= $activeTab ?? "tarea" ?>';
</script>
</body>

</html>
