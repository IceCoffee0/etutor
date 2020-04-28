<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(3);
    if($authorized == true) {$userRole = $_SESSION['role'];}
?>
<?php if($authorized == true): ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
            if($userRole == 3) {
                echo "Staff Main Panel";
            } elseif($userRole == 4) {
                echo 'Manager Main Panel';
            }
        ?>
    </title>
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
                        <li class="sidebar-mobile__item">
                            <a href="admin_panel.php" class="sidebar-mobile__link">DashBoard</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a class="sidebar-mobile__link">User List</a>
                        </li>
                    </ul>
                    <ul class="sub-sidebar-mobile__list">
                        <?php if($userRole == 4):?>
                        <li class="sub-sidebar-mobile__item">
                            <a href="admin_account_staff.php" class="sub-sidebar-mobile__link">Staff</a>
                        </li>
                        <?php endif;?>
                        <li class="sub-sidebar-mobile__item">
                            <a href="admin_account_tutor.php" class="sub-sidebar-mobile__link">Tutor</a>
                        </li>
                        <li class="sub-sidebar-mobile__item">
                            <a href="admin_account_student.php" class="sub-sidebar-mobile__link">Student</a>
                        </li>
                    </ul>
                    <?php if($userRole == 4): ?>
                    <ul class="sidebar-mobile__list">
                        <li class="sidebar-mobile__item">
                            <a href="" class="sidebar-mobile__link">View report</a>
                        </li>
                    </ul>
                    <ul class="sub-sidebar-mobile__list">
                        <li class="sub-sidebar-mobile__item">
                            <a href="admin_report.php" class="sub-sidebar-mobile__link">Statistic report</a>
                        </li>
                        <li class="sub-sidebar-mobile__item">
                            <a href="admin_activitylog.php" class="sub-sidebar-mobile__link">Activity log</a>
                        </li>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
            <div class="header__right">
                <div class="tx-color">
                    <span>
                        Hi, <?= explode(" ",getUserFullNameAndId($_SESSION['uid'])[0])[0]?>
                    </span>
                </div>
              <li class="setting">
                <a>
                    <img src="assets/image/setting.png" alt="">
                </a>
                <ul class="profile">
                    <li class="profile__item">
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
                    <li class="sidebar__item">
                        <a href="admin_panel.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a class="sidebar__link">User List</a>
                    </li>
                </ul>
                <ul class="sub-sidebar__list">
                    <?php if($userRole == 4):?>
                        <li class="sub-sidebar__item">
                            <a href="admin_account_staff.php" class="sub-sidebar__link">Staff</a>
                        </li>
                    <?php endif;?>
                    <li class="sub-sidebar__item">
                        <a href="admin_account_tutor.php" class="sub-sidebar__link">Tutor</a>
                    </li>
                    <li class="sub-sidebar__item">
                        <a href="admin_account_student.php" class="sub-sidebar__link">Student</a>
                    </li>
                </ul>
                <?php if($userRole == 4): ?>
                <ul class="sidebar__list">
                    <li class="sidebar__item">
                        <a class="sidebar__link">View report</a>
                    </li>
                </ul>
                <ul class="sub-sidebar__list">
                    <?php if($userRole == 4):?>
                        <li class="sub-sidebar__item">
                            <a href="admin_report.php" class="sub-sidebar__link">Statistic report</a>
                        </li>
                    <?php endif;?>
                    <li class="sub-sidebar__item">
                        <a href="admin_activitylog.php" class="sub-sidebar__link">Activity Log</a>
                    </li>
                </ul>
                <?php endif; ?>
            </div>
            <div class="content">
                <h2 class="title">
                    <?php 
                        if($userRole == 3) {
                            echo "Staff Main Panel";
                        } elseif($userRole == 4) {
                            echo 'Manager Main Panel';
                        }
                    ?>
                </h2>
                <div class="list">
                    <div class="list__item">
                        <div class="activity">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-signal"></i>
                                </a>
                                <p class="title-post__text">Recent Activities</p>
                            </div>
                            <div class="active__list">
                                <?php $recentActivities = getActivity_asUser($_SESSION['uid'], 5); ?>
                                <?php if(count($recentActivities) > 0):?>
                                    <?php foreach($recentActivities as $activity):?>
                                    <div class="active__memmber">
                                        <div class="active__text">
                                            <?= $activity?>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php endforeach;?>
                                <?php else:?>
                                <div class="active__memmber">
                                    <div class="active__text">
                                        No recent activities
                                    </div>
                                </div>
                                <?php endif;?>
                                
                            </div>
<!--                            <div class="viewall">
                                <a href="">
                                    View all
                                </a>
                            </div>-->
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="accounts">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <p class="title-post__text">New Users</p>
                            </div>
                            <div class="account__list">
                                <?php 
                                    $query = "SELECT * FROM users WHERE role_id IN(1,2) ORDER BY user_id DESC LIMIT 5";
                                    $result = queryMysql($query);
                                ?>
                                <?php while ($row = $result->fetch_assoc()):?>
                                <div class="account__item">
                                    <div><?= $row['fullname']?></div>
                                    <div class="account__func">
<!--                                        <a>Edit</a>
                                        <a>Delete</a>-->
                                    </div>
                                </div>
                                <?php endwhile;?>
                            </div>
<!--                            <div class="viewall">
                                <a href="">
                                    View all
                                </a>
                            </div>-->
                        </div>
                    </div>
                    <div class="list__item">
                        <div class="status">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Tutor and Student report</p>
                            </div>
                            <div class="status__list">
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of unallocated students</div>
                                        <div></div>
                                    </div>
                                    <div class="status__point">
                                        <?php 
                                            $unAlloStudents = count(getUnAllocatedStudents());
                                            echo $unAlloStudents;
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of tutor without any student</div>
                                        <div></div>
                                    </div>
                                    <div class="status__point">
                                        <?php 
                                            $counter = 0;
                                            $tutorIds = array();
                                            $query = "SELECT tutor_id FROM allocation";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_array()) {
                                                array_push($tutorIds, $row['tutor_id']);
                                            }
                                            $query = "SELECT user_id FROM users WHERE role_id = 1";
                                            $result = queryMysql($query);
                                            while($row = $result->fetch_array()) {
                                                if(!in_array($row['user_id'], $tutorIds)) {
                                                    $counter++;
                                                }
                                            }
                                            echo $counter;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                   <div class="list__item">
                        <div class="notifications">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <p class="title-post__text">Alert Message and Notifications</p>
                            </div>
                            <div class="notification__item">
                                <div class="notification__text">Liala added a new comment to the public form.</div>
                                <a href="">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
                            </div>
                            <div class="notification__item">
                                <div class="notification__text">Liala added a new comment to the public form.</div>
                                <a href="">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
                            </div>
                            <div class="notification__item">
                                <div class="notification__text">Liala added a new comment to the public form.</div>
                                <a href="">
                                    <i class="fas fa-exclamation-circle"></i>
                                </a>
                            </div>
                        </div>
                   </div>-->
<!--                   <div class="list__item">
                        <div class="activity">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Tutor with no student</p>
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
                            </div>
                            <div class="viewall">
                                <a href="admin_account_tutor.php">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="list__item">
                        <div class="activity">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Unallocated Student</p>
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
                            </div>
                            <div class="viewall">
                                <a href="admin_account_student.php">
                                    View all
                                </a>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>
            <div class="clearfix"></div>
    </div>
</body>
</html>
<?php endif; ?>