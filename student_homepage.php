<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(1);
    if($authorized == true) {$roleId = $_SESSION['role'];}
    if(isset($_GET['studentId'])) {
        $userId = $_GET['studentId'];
    } else {
        $userId = $_SESSION['uid'];
    }
?>

<?php if($authorized == true): ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Homepage</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
</head>
<body style="background-image: url('assets/image/bg.jpg'); background-size: cover;">
        <!-- header -->
        <header class="header">
            <div class="header__left">
                <a class="header__item">
                    <img src="assets/image/clock.png" alt="">
                </a>
                <a class="header__item">
                    <img src="assets/image/coppy.png" alt="">
                </a>
                <a class="header__item">
                    <img src="assets/image/email.png" alt="">
                </a>
                <!-- icon-navbar-mobile -->
                <label for="nav-sidebar-input" class="nav-sidebar">
                    <i class="fas fa-bars"></i>
                </label>
                <input type="checkbox" name="" hidden class="nav-input" id="nav-sidebar-input">
                <label for="nav-sidebar-input" class="nav-overlay"></label>
                <!-- sidebar-mobile -->
                <div class="sidebar-mobile">
                    <div class="sidebar-mobile__header">
                        <div class="tx-color">
                            <span>
                                Hi, <?= explode(" ",getUserFullNameAndId($_SESSION['uid'])[0])[0]?>
                            </span>
                        </div>
                        <label for="nav-sidebar-input" class="sidebar-mobile__close">    
                            <i class="fas fa-times"></i>
                        </label>
                    </div>
                    <ul class="sidebar-mobile__list">
                        <?php if($roleId == 2):?>
                        <li class="sidebar-mobile__item">
                            <a href="student_homepage.php" class="sidebar-mobile__link">DashBoard</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="student_assignment.php" class="sidebar-mobile__link">Word submission</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="tutors_document.php" class="sidebar-mobile__link">Tutor's document</a>
                        </li>
                        <?php elseif($roleId == 1):?>
                        <li class="sidebar-mobile__item">
                            <a href="tutor_homepage.php" class="sidebar-mobile__link">Back to your page</a>
                        </li>
                        <?php elseif($roleId >= 3):?>
                        <li class="sidebar-mobile__item">
                            <a href="admin_account_student.php" class="sidebar-mobile__link">Back to management</a>
                        </li>
                        <?php endif; ?>
                    </ul>
<!--                    <ul class="sub-sidebar-mobile__list">
                        <li class="sub-sidebar-mobile__item">
                            <a href="" class="sub-sidebar-mobile__link">Tutor</a>
                        </li>
                        <li class="sub-sidebar-mobile__item">
                            <a href="" class="sub-sidebar-mobile__link">Student</a>
                        </li>
                    </ul>-->
                </div>
            </div>
            <div class="header__right">
                <div class="tx-color">
                    <span>
                        Hi, <?= explode(" ",getUserFullNameAndId($_SESSION['uid'])[0])[0]?>
                    </span>
                </div>
              <li class="setting">
                <a href="">
                    <img src="assets/image/setting.png" alt="">
                </a>
                <ul class="profile">
                    <li class="profile__item">
                        <a href="" class="profile__link">
                            
                        </a>
                        <a href="logout_func.php" class="profile__link">
                            Logout
                        </a>
                    </li>
                </ul>
              </li>
            </div>
        </header>
    <!-- main -->
    <div class="main" style="position: relative;">
            <!-- sidebar -->
            <div class="sidebar">
                <ul class="sidebar__list">
                    <?php if($roleId == 2):?>
                    <li class="sidebar__item">
                        <a href="student_homepage.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="student_assignment.php" class="sidebar__link">Work submission</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="tutors_document.php" class="sidebar__link">Tutor's document</a>
                    </li>
                    <?php elseif($roleId == 1): ?>
                    <li class="sidebar__item">
                        <a href="tutor_homepage.php" class="sidebar__link">Back to your page</a>
                    </li>
                    <?php elseif($roleId >= 3): ?>
                    <li class="sidebar__item">
                        <a href="admin_account_student.php" class="sidebar__link">Back to management</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="content">
                <h2 class="title">
                    Dashboard
                </h2>
                <h3 class="title">
                    <?= explode(" ",getUserFullNameAndId($userId)[0])[0] ?>
                </h3>
                <div class="list">
                    <div class="list__item">
                        <div class="activity">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-signal"></i>
                                </a>
                                <p class="title-post__text">Recent Activity</p>
                            </div>
                            <div class="active__list">
                                
                                <?php $actities = getActivity_asUser($userId, 3)?>
                                <?php if(count($actities) > 0):?>
                                    <?php foreach ($actities as $activity):?>
                                        <div class="active__memmber">
                                            <div class="active__text">
                                                <?= $activity ?>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                <?php else: ?>
                                    <div class="active__memmber">
                                            <div class="active__text">
                                                No recent activities
                                            </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="list__item-9 list__item">
                        <div class="status">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Your tutor</p>
                            </div>
                            <div class="status__list">
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">
                                            <?php 
                                                $tutorName = getTutorName($userId);
                                                if($tutorName == null) {
                                                    echo "No tutor assigned";
                                                } else {
                                                    echo explode(" ", $tutorName)[0];
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <div class="list__item-9 list__item">
                        <div class="activity">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Unassign Tutor</p>
                            </div>
                            <div class="active__list">
                                <div class="active__memmber">
                                    <a href="" class="active__img">
                                        <img src="assets/image/icon.png" alt="">
                                    </a>
                                    <div class="active__text">
                                        Liala added a new comment to the
                                        public form.
                                    </div>
                                </div>
                                <div class="active__memmber">
                                    <a href="" class="active__img">
                                        <img src="assets/image/icon.png" alt="">
                                    </a>
                                    <div class="active__text">
                                        Liala added a new comment to the
                                        public form.
                                    </div>
                                </div>
                                <div class="active__memmber">
                                    <a href="" class="active__img">
                                        <img src="assets/image/icon.png" alt="">
                                    </a>
                                    <div class="active__text">
                                        Liala added a new comment to the
                                        public form.
                                    </div>
                                </div>
                            </div>
                            <div class="viewall">
                                <a href="">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>-->
                   <div class="list__item-12 list__item-9 list__item-8">
                        <div class="notifications">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <p class="title-post__text">Related activities</p>
                            </div>
                            <?php $relatedActivities = getActivity_asTarget($userId, 3) ?>
                            <?php if(count($relatedActivities) > 0): ?>
                                <?php foreach ($relatedActivities as $activity):?>
                                <div class="notification__item">
                                    <div class="notification__text"><?= $activity?></div>
                                    <a href="">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </a>
                                </div>
                                <?php endforeach;?>
                            <?php else: ?>
                                <div class="notification__item">
                                    <div class="notification__text">No related activities</div>
                                    <a href="">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                   </div>
                </div>
            </div>
            <div class="clearfix"></div>
    </div>
</body>
</html>
<?php endif; ?>