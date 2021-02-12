<?php

require '../utils/getQuerys.php';

use QueryHelper\QueryHelper;

session_start();
$query = new QueryHelper();
$user = $query->getUserByid(intval($_SESSION['uid']));
session_write_close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Badge</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="animsition">
<!-- HEADER DESKTOP-->
<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="../resources/img/logo.png" alt="Cool Admin"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-archive"></i>Cursos</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>Asignaturas</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-check-square"></i>Tareas</a>
                </li>
                <li class="has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-users"></i>Alumnos</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->

<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header4-wrap">
                <div class="form-header">
                </div>
                <div class="header-button">

                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image">
                                <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png"
                                     alt="John Doe"/>
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">username</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png"
                                                 alt="user ic"/>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">username</a>
                                        </h5>
                                        <?php
                                        echo '<span class="email">' . $user->getEmail() . '</span>' ?>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-settings"></i>Setting</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer">
                                    <a href="logout.php">
                                        <i class="zmdi zmdi-power"></i>Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


</div>

<!-- Jquery JS-->
<script src="../resources/template/vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="../resources/template/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="../resources/template/vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="../resources/template/vendor/slick/slick.min.js">
</script>
<script src="../resources/template/vendor/wow/wow.min.js"></script>
<script src="../resources/template/vendor/animsition/animsition.min.js"></script>
<script src="../resources/template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="../resources/template/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="../resources/template/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="../resources/template/vendor/circle-progress/circle-progress.min.js"></script>
<script src="../resources/template/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../resources/template/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="../resources/template/vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="../resources/template/js/main.js"></script>

</body>

</html>

<!-- end document-->
