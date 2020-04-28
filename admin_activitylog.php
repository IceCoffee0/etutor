<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(4);
    $thisPage = "admin_account_staff.php";
    if($authorized == true) {$userRole = $_SESSION['role'];}
    
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 10;
    $offset = ($pageno-1) * $no_of_records_per_page;

    $total_pages_sql = "SELECT COUNT(*) FROM activity_log";
    $result = queryMysql($total_pages_sql);
    $total_rows = $result->fetch_array()[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    $sql = "SELECT * FROM activity_log ORDER BY id DESC LIMIT $offset, $no_of_records_per_page";
    $res_data = queryMysql($sql);
?>
<?php if($authorized == true): ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .dialog {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: opacity linear 0.2s;
        }
        .overlay-close{
            position: absolute;
            width: 100%;
            height: 100%;
        }
        .dialog:target{
            visibility: visible;
            opacity: 1;
        }
        .overlay{
            background-color: rgba(0,0,0,0);
        }
        .dialog-body{
            position: relative;
            width: 702px;
            height: 482px;
            padding: 16px;
            background-color: #3f3731;
        }
        .dialog-close-btn{
            position: absolute;
            top: 2px;
            right: 6px;
            text-decoration: none;
            color: white;
        }
    </style>
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
            <h1 class="title">
                All activities in the system
            </h1>
            <div style="overflow-x: auto;">
                <table class="table table-color">
                    <thead>
                        <tr>
                            <th>Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $res_data->fetch_assoc()):?>
                        <tr>
                            <td><?= processActivityLog($row, "user", true) ?></td>
                        </tr>
                        <?php endwhile;?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12" style="padding-top: 1%">
                <nav class="float-right" aria-label="Page navigation student">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                        <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                        </li>
                        <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                    </ul>
                </nav>
            </div>  
        </div>
        <div class="clearfix"></div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    var options = [];
    var total=$(this).find('input[name="student[]"]:checked').length;

    $( '.dropdown-menu a' ).on( 'click', function( event ) {

       var $target = $( event.currentTarget ),
           val = $target.attr( 'data-value' ),
           $inp = $target.find( 'input' ),
           idx;

       if ( ( idx = options.indexOf( val ) ) > -1 ) {
          options.splice( idx, 1 );
          setTimeout( function() { $inp.prop( 'checked', false ) }, 0);
       } else {
          options.push( val );
          setTimeout( function() { $inp.prop( 'checked', true ) }, 0);
       }

       $( event.target ).blur();

       console.log( options );
       return false;
    });
</script>
</html>
<?php endif; ?>