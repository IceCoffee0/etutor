<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(1);
    if($authorized == true) {$roleId = $_SESSION['role'];}
    
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
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
                        <a href="tutor_homepage.php" class="sidebar-mobile__link">DashBoard</a>
                    </li>
                    <li class="sidebar-mobile__item">
                        <a href="student_assignment.php" class="sidebar-mobile__link">Student Submission</a>
                    </li>
                </ul>
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
                    <a href="" class="profile__link">
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
                        <a href="tutor_homepage.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="student_assignment.php" class="sidebar__link">Student Submission</a>
                    </li>
                </ul>
            </div>
            <div class="content">
                <h2 class="title">
                    Dashboard
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
                                <?php $activities = getActivity_asUser($_SESSION['uid'], 5)?>
                                <?php if(count($activities) > 0):?>
                                    <?php foreach ($activities as $activity): ?>
                                        <div class="active__memmber">
                                            <div class="active__text">
                                                    <?= $activity ?>
                                            </div>
                                        </div>  
                                    <?php endforeach; ?>
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
                    <div class="list__item">
                        <div class="accounts">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <p class="title-post__text">Your students</p>
                            </div>
                            <div class="account__list">
                                <?php $students = getTutorsStudent($_SESSION['uid'])?>
                                <?php if($students != null):?>
                                    <?php foreach($students as $student):?>
                                        <div class="account__item">
                                            <div><?= $student['fullname']?></div>
                                            <div class="account__func">
                                                <a href="student_homepage.php?studentId=<?= $student['user_id']?>">Visit</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="account__item">
                                        <div>No allocated student</div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                   <div class="list__item-12 list__item-9 list__item-8">
                        <div class="notifications">
                            <div class="title-post" style="  background-color: #8e7161;">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <p class="title-post__text">Student Recent Activities</p>
                            </div>
                            
                            <?php 
                                $students = getTutorsStudent($_SESSION['uid']);
                                $studentIds = array();
                                foreach($students  as $student) {
                                    array_push($studentIds, $student['user_id']);
                                }
                                $studentIds = implode(",", $studentIds);
                                $query = "SELECT * FROM activity_log WHERE user_id IN($studentIds) ORDER BY time DESC LIMIT 5";
                                $result = queryMysql($query);
                            ?>
                            <?php if(mysqli_num_rows($result) > 0):?>
                                <?php while ($row = $result->fetch_assoc()):?>
                                <div class="notification__item">
                                    <div class="notification__text"><?= processActivityLog($row, "user"); ?></div>
                                    <a>
                                        <i class="fas fa-exclamation-circle"></i>
                                    </a>
                                </div>
                                <?php endwhile;?>
                            <?php else: ?>
                                <div class="notification__item">
                                    <div class="notification__text">No recent activities from students</div>
                                </div>
                            <?php endif;?>
                        </div>
                   </div>
                </div>
            </div>
            <div class="clearfix"></div>
    </div>
</body>
</html>