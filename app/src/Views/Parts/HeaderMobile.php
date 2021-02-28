<?php $currentUri = explode("/",$_SERVER['REQUEST_URI'])[1]; ?>

<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="/Course">
                    <img src="/resources/img/logo.png" width="100" alt="Logo"/>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <?php  echo $currentUri === 'Course' ? '<li class="has-sub active">' :  '<li class="has-sub">';?>
                <a class="js-arrow" href="/Course">
                    <i class="fas fa-archive"></i>Course</a>
                </li>
                <?php  echo $currentUri === 'Subject' ? '<li class="has-sub active">' :  '<li class="has-sub">';?>

                <a class="js-arrow" href="/Subject">
                    <i class="fas fa-book"></i>Subject</a>
                </li>
                <?php  echo $currentUri === 'Task' ? '<li class="has-sub active">' :  '<li class="has-sub">';?>

                <a class="js-arrow" href="/Task">
                    <i class="fas fa-check-square"></i>Task</a>
                </li>
                <?php  echo $currentUri === 'Students' ? '<li class="has-sub active">' :  '<li class="has-sub">';?>

                <a class="js-arrow" href="/Students">
                    <i class="fas fa-users"></i>Students</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
