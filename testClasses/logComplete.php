<?php
require '../utils/Medoo.php';

use Medoo\Medoo;

$database = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'task_manager',
    'server' => 'localhost',
    'username' => 'root',
    'password' => ''
]);
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

    <!-- Fontfaces CSS-->
    <link href="../template/css/font-face.css" rel="stylesheet" media="all">
    <link href="../template/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../template/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../template/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../template/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="../template/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="../template/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet"
          media="all">
    <link href="../template/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="../template/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="../template/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="../template/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../template/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../template/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">

<div class="card">
    <div class="card-header">
        <strong>Usuario</strong>
    </div>
    <div class="card-body">

        <?php

        $res = $database -> select("usuario","*",["id"=>$_GET["response"]]);
        echo 'Correo: ';
        echo '<span class="badge badge-success">' . $res[0]["email"] . '</span>';
        echo '<br/>';
        echo 'Contraseña: ';
        echo '<span class="badge badge-info">' . $res[0]["password"] . '</span>';
        ?>
    </div>
</div>

</div>

<!-- Jquery JS-->
<script src="../template/vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="../template/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="../template/vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="../template/vendor/slick/slick.min.js">
</script>
<script src="../template/vendor/wow/wow.min.js"></script>
<script src="../template/vendor/animsition/animsition.min.js"></script>
<script src="../template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="../template/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="../template/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="../template/vendor/circle-progress/circle-progress.min.js"></script>
<script src="../template/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../template/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="../template/vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="../template/js/main.js"></script>

</body>

</html>

<!-- end document-->
