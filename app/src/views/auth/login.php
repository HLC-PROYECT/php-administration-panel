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
    <title>Login</title>
    <link rel="stylesheet" href="resources/styles/style.css">
    <link href="resources/toastr/toastr.css" rel="stylesheet"/>
</head>

<body class="animsition">

<form action="login" method="post">

    <div class="page-wrapper" style="overflow: scroll;">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="resources/img/logo.png" alt="logo">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input required class="au-input au-input--full" type="email" name="email"
                                           placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required class="au-input au-input--full" type="password" name="password"
                                           placeholder="Password">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" value="remember">Remember Me
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" name="submit"
                                        type="submit">sign in
                                </button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="register.html">Sign Up Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

<script src="resources/toastr/jquery-3.5.1.min.js"></script>
<script src="resources/toastr/toastr.min.js"></script>
<!-- Jquery JS-->
<script src="resources/template/vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="resources/template/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="resources/template/vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor Jtemplate/S       -->
<script src="resources/template/vendor/slick/slick.min.js">
</script>
<script src="resources/template/vendor/wow/wow.min.js"></script>
<script src="resources/template/vendor/animsition/animsition.min.js"></script>
<script src="resources/template/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="resources/template/vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="resources/template/vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="resources/template/vendor/circle-progress/circle-progress.min.js"></script>
<script src="resources/template/vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="resources/template/vendor/chartjs/Chart.bundle.min.js"></script>
<script src="resources/template/vendor/select2/select2.min.js"></script>
<!-- Main JS-->
<script src="resources/template/js/main.js"></script>
<script src="resources/js/authErrorController.js"></script>
<?php
foreach ($this->errors as $value) {
    echo $value;
    echo '<script type="text/javascript">',
        'showError("' . $value . '");',
    '</script>';
}
?>
</body>
</html>