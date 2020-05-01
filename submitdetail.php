<?php
require './functions.php';
session_start();
validateUser(1);
$userId = $_SESSION['uid'];
$role = $_SESSION['role'];
$tutorId = null;
if(isset($_GET['smid'])) {
    $smid = $_GET['smid'];
} else {
    header('Refresh: 2; URL=student_assignment.php');
    echo "<script>alert('Invalid submission ID')</script>";
    echo "Redirecting ...";
}
?>
<?php if($smid != null):?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Detail</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e76434167d.js" crossorigin="anonymous"></script>
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
                        <?php if($role == 2):?>
                        <li class="sidebar-mobile__item">
                            <a href="student_homepage.php" class="sidebar-mobile__link">DashBoard</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="student_assignment.php" class="sidebar-mobile__link">Work submission</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="tutors_document.php" class="sidebar-mobile__link">Tutor's document</a>
                        </li>
                        <?php endif; ?>
                        <?php if($role == 1):?>
                        <li class="sidebar-mobile__item">
                            <a href="tutor_homepage.php" class="sidebar-mobile__link">DashBoard</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="student_assignment.php" class="sidebar-mobile__link">Work submission</a>
                        </li>
                        <?php endif; ?>
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
                    <?php if($role == 2):?>
                    <li class="sidebar__item">
                        <a href="student_homepage.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="student_assignment.php" class="sidebar__link">Work submission</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="tutors_document.php" class="sidebar__link">Tutor's document</a>
                    </li>
                    <?php endif; ?>
                    <?php if($role == 1):?>
                    <li class="sidebar__item">
                        <a href="tutor_homepage.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="student_assignment.php" class="sidebar__link">Work submission</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="content">
                <h2 class="title">
                    Assignment
                </h2>
                <?php 
                    $query = "SELECT * FROM file_upload WHERE id = '$smid'";
                    $result = queryMysql($query);
                    $row = $result->fetch_assoc();
                ?>
                <div class="col-md-6">
                    <form action="viewSubmission_func.php" method="post" id="viewSubmit">
                        <input type="hidden" name="role" value="<?= $role?>">
                        <input type="hidden" name="smid" value="<?= $smid?>">
                        <input type="hidden" name="user" value="<?= $userId?>">
                        <div class="form-group">
                          <label for="inputTitle">Title</label>
                          <input type="text" class="form-control" name="title" id="inputTitle" value="<?= $row['title']?>" <?php if($role != 2) {echo "readonly";}?> required>
                        </div>

                        <div class="form-group">
                          <label for="sender">Sender</label>
                          <input type="text" class="form-control" id="sender" value="<?= getUserFullNameAndId($row['sender'])[0]?>" readonly>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="file">File</label>
                            <input type="text" class="form-control" id="file" placeholder="<?= str_replace("data/", "", $row['file_path']); ?>" disabled required>
                            <input type="hidden" name="filepath" value="<?= $row['file_path']?>">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="downloadbnt">Action</label> <br>
                              <a id="downloadbtn" class="btn btn-success" href="<?= $row['file_path']?>" download>Download</a>
                          </div>
                        </div>

                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" id="desc" rows="3" name="desc" form="viewSubmit" <?php if($role != 2) {echo "readonly";}?> required><?= $row['description']?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="feedback">Feedback</label>
                            <textarea class="form-control" id="feedback" rows="3" name="feedback" form="viewSubmit" <?php if($role != 1) {echo "readonly";} ?> ><?= $row['feedback']?></textarea>
                        </div>
                        <button type="submit" name="saveSubmit" value="save" class="btn btn-primary">Save</button>
                        <a class="btn btn-secondary" href="student_assignment.php">Back</a>
                    </form>
                </div>
            </div>
            <div class="clearfix"></div>
    </div>
</body>
</html>
<?php endif; ?>