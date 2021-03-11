<?php
$currentUri = explode("/", $_SERVER['REQUEST_URI'])[1];
$isTeacher = $this->user->getType() === 'P';
?>

<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="/resources/img/logo.png" alt="Cool Admin"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">

                <?php echo $currentUri === 'Course' ? '<li class="has-sub active">' : '<li class="has-sub">'; ?>
                <a class="js-arrow" href="/course">
                    <i class="fas fa-archive"></i>Course</a>
                </li>
                <?php echo $currentUri === 'Subject' ? '<li class="has-sub active">' : '<li class="has-sub">'; ?>
                <a class="js-arrow" href="/subject">
                    <i class="fas fa-book"></i>Subject</a>
                </li>
                <?php echo $currentUri === 'Task' ? '<li class="has-sub active">' : '<li class="has-sub">'; ?>

                <a class="js-arrow" href="/task">
                    <i class="fas fa-check-square"></i>Task</a>
                </li>

                <?php
                if ($isTeacher) {
                    ?>
                    <?php echo $currentUri === 'Students' ? '<li class="has-sub active">' : '<li class="has-sub">'; ?>

                    <a class="js-arrow" href="/student">
                        <i class="fas fa-users"></i>Students</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </nav>
    </div>
</aside>