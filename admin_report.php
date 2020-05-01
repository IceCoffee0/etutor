<?php 
    require './activityManager.php';
    session_start();
    $authorized = validateUser(4);
    if($authorized == true) {$userRole = $_SESSION['role'];}
?>
<?php if($authorized == true): ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
</head>
<body style="background-image: url('assets/image/bg.jpg'); background-size: cover;">
        <!-- header -->
        <header class="header">
            <div class="header__left">
                <a href="#" class="header__item">
                    <img src="assets/image/clock.png" alt="">
                </a>
                <a href="#" class="header__item">
                    <img src="assets/image/coppy.png" alt="">
                </a>
                <a href="#" class="header__item">
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
                            <a class="sidebar-mobile__link">View report</a>
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
                    Report
                </h2>

                <div class="list">
                    <div class="list__item">
                        <div class="status">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Statistic report</p>
                            </div>
                            <div class="status__list">
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of staff</div>
                                        <div>The active staff in the system</div>
                                    </div>
                                    <div class="status__point">
                                        <?php echo mysqli_num_rows(getuserList("staff"))?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of tutor</div>
                                        <div>The active tutor in the system</div>
                                    </div>
                                    <div class="status__point">
                                        <?php echo mysqli_num_rows(getuserList("tutor"))?>
                                    </div>
                                </div>
                               <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of student</div>
                                        <div>The active student in the system</div>
                                    </div>
                                    <div class="status__point">
                                        <?php echo mysqli_num_rows(getuserList("student"))?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of file</div>
                                        <div>The total number of file uploaded to the system</div>
                                    </div>
                                    <div class="status__point">
                                        <?php 
                                            $query = "SELECT * FROM file_upload";
                                            $result = queryMysql($query);
                                            echo mysqli_num_rows($result);
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of file submit by the student</div>
                                        <div>Document and report submitted by student</div>
                                    </div>
                                    <div class="status__point">
                                        <?php
                                            $studentIds = array();
                                            $counter = 0;
                                            $query = "SELECT user_id FROM users where role_id = 2";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                array_push($studentIds, $row['user_id']);
                                            }
                                            $query = "SELECT sender FROM file_upload";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if(in_array($row['sender'], $studentIds)) {
                                                    $counter++;
                                                }
                                            }
                                            echo $counter;
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of file send by tutor</div>
                                        <div>Document send to the student by the tutor</div>
                                    </div>
                                    <div class="status__point">
                                        <?php
                                            $tutorIds = array();
                                            $counter = 0;
                                            $query = "SELECT user_id FROM users where role_id = 1";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                array_push($tutorIds, $row['user_id']);
                                            }
                                            $query = "SELECT sender FROM file_upload";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if(in_array($row['sender'], $tutorIds)) {
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
                    
                    <div class="list__item">
                        <div class="status">
                            <div class="title-post">
                                <a href="" class="title-post__icon">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                                <p class="title-post__text">Exception report</p>
                            </div>
                            <div class="status__list">
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of tutor with out a student</div>
                                        <div>Tutor who has not been assigned any student</div>
                                    </div>
                                    <div class="status__point">
                                        <?php
                                            $assignedTutors = array();
                                            $counter = 0;
                                            $query = "SELECT tutor_id FROM allocation";
                                            $result = queryMysql($query);
                                            while($row = $result->fetch_assoc()) {
                                                array_push($assignedTutors, $row['tutor_id']);
                                            }
                                            $query = "SELECT user_id FROM users WHERE role_id = 1";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if(!in_array($row['user_id'], $assignedTutors)) {
                                                    $counter++;
                                                }
                                            }
                                            echo $counter;
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of student without a tutor</div>
                                        <div>Student who is not allocated to any tutor</div>
                                    </div>
                                    <div class="status__point">
                                        <?= count(getUnAllocatedStudents())?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of submission that are not reviewed</div>
                                        <div>Submission by student that are not reviewed by the tutor</div>
                                    </div>
                                    <div class="status__point">
                                        <?php
                                            $counter = 0;
                                            $query = "SELECT feedback FROM file_upload";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if($row['feedback'] == null || $row['feedback'] == "") {
                                                    $counter++;
                                                }
                                            }
                                            echo $counter;
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of inactive student</div>
                                        <div>Student who has not submitted any work or report</div>
                                    </div>
                                    <div class="status__point">
                                        <?php 
                                            $activeUsers = array();
                                            $counter = 0;
                                            $query = "SELECT DISTINCT sender FROM file_upload";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                array_push($activeUsers, $row['sender']);
                                            }
                                            $query = "SELECT user_id FROM users WHERE role_id = 2";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if(!in_array($row['user_id'], $activeUsers)) {
                                                    $counter++;
                                                }
                                            }
                                            echo $counter;
                                        ?>
                                    </div>
                                </div>
                                <div class="status__item">
                                    <div class="status__assigne">
                                        <div class="status__title">Number of inactive tutor</div>
                                        <div>Student who has not send any documents or review student's works and reports</div>
                                    </div>
                                    <div class="status__point">
                                        <?php
                                            $counter = 0;
                                            $query = "SELECT user_id FROM users WHERE role_id = 1";
                                            $result = queryMysql($query);
                                            while ($row = $result->fetch_assoc()) {
                                                if(!in_array($row['user_id'], $activeUsers)) {
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
                    
            </div>
            <div class="clearfix"></div>
    </div>
</body>
</html>
<?php endif; ?>