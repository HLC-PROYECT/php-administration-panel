<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="register tab">
    <meta name="author" content="saladillo">
    <meta name="keywords" content="task manager">


    <link rel="stylesheet" href="/resources/styles/auth/register.css">
    <link rel="stylesheet" href="/resources/styles/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"
          integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <!-- Title Page-->
    <title>Register</title>


</head>
<body class="animsition">

<form action="" method="post">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="/resources/img/logo.png" alt="logo">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Identification document</label>
                                    <input pattern="[0-9]{8}[A-Za-z]{1}"
                                           title="Format example: 12345678A"
                                           required
                                           class="au-input au-input--full"
                                           type="text"
                                           minlength="9"
                                           maxlength="9"
                                           name="identificationDocument"
                                           placeholder="Identification document">
                                </div>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input required
                                           class="au-input au-input--full"
                                           type="text"
                                           name="name"
                                           placeholder="Name">
                                </div>

                                <div class="form-group">
                                    <label>Nick name</label>
                                    <input required
                                           class="au-input au-input--full"
                                           type="text"
                                           name="nick"
                                           placeholder="Nick name">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input required
                                           class="au-input au-input--full"
                                           type="email"
                                           name="email"
                                           placeholder="email">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input required
                                           class="au-input au-input--full"
                                           minlength="8"
                                           type="password"
                                           name="password"
                                           placeholder="Password">
                                </div>
                                <label>User type:</label>
                                <div class="cont">
                                    <div class="container">
                                        <div id="radios">
                                            <label for="pupil" class="material-icons">
                                                <input type="radio"
                                                       name="type"
                                                       id="pupil"
                                                       value="a"
                                                       checked/>
                                                <span><i class="ic fas fa-book-reader"></i></span>
                                            </label>
                                            <label for="teacher" class=" material-icons">
                                                <input type="radio"
                                                       name="type"
                                                       id="teacher"
                                                       value="p"/>
                                                <span><i class="fas fa-chalkboard-teacher"></i></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="selector1">
                                    <label>Course ID</label>
                                    <input class="au-input au-input--full"
                                           id="courseId"
                                           type="number"
                                           name="courseId"
                                           placeholder="Course ID">
                                </div>
                                <div class="form-group" id="selector2">
                                    <label>date of birth</label>
                                    <input class="au-input au-input--full"
                                           id="dateBirth"
                                           type="date"
                                           name="dateBirth"
                                           placeholder="dd/mm/yyyy">
                                </div>

                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox"
                                               name="remember"
                                               value="remember">
                                        Remember Me
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20"
                                        name="submit"
                                        type="submit">
                                    sign up
                                </button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Do you have an account?
                                    <a href="/login">Login Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/../Parts/Js.php'; ?>

<script src="/resources/js/registerInputControllers.js"></script>
</body>
</html>


