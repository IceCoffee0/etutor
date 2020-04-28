<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(2);
    
    if($authorized == true) {
        $page = "tutors_document.php";
        $userId = $_SESSION['uid'];
        $role = $_SESSION['role'];
        $tutorId = null;
        if($role == 2) {
            $tutorId = findTutor($userId);
        }

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 5;
        $offset = ($pageno-1) * $no_of_records_per_page;

        
        if($role == 2 && $tutorId !== null) {
            $total_pages_sql = "SELECT COUNT(*) FROM file_upload WHERE sender = '$tutorId' AND receiver = '$userId'";
            $result = queryMysql($total_pages_sql);
            $total_rows = $result->fetch_array()[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $sql = "SELECT * FROM file_upload WHERE sender = '$tutorId' AND receiver = '$userId' LIMIT $offset, $no_of_records_per_page";
            $res_data = queryMysql($sql);
        }
    }
    
    
?>

<?php if($authorized == true): ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work and report submission</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/bootstrap-grid.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome-free-5.12.1-web/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
                                Hi, <?= getUserFullNameAndId($_SESSION['uid'])[0]?>
                            </span>
                        </div>
                        <label for="nav-sidebar-input" class="sidebar-mobile__close">    
                            <i class="fas fa-times"></i>
                        </label>
                    </div>
                    <ul class="sidebar-mobile__list">
                        <li class="sidebar-mobile__item">
                            <a href="student_homepage.php" class="sidebar-mobile__link">DashBoard</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="student_assignment.php" class="sidebar-mobile__link">Work submission</a>
                        </li>
                        <li class="sidebar-mobile__item">
                            <a href="tutors_document.php" class="sidebar-mobile__link">Tutor's document</a>
                        </li>
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
                        Hi, <?= getUserFullNameAndId($_SESSION['uid'])[0]?>
                    </span>
                </div>
              <li class="setting">
                <a>
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
                        <a href="student_homepage.php" class="sidebar__link">DashBoard</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="student_assignment.php" class="sidebar__link">Work submission</a>
                    </li>
                    <li class="sidebar__item">
                        <a href="tutors_document.php" class="sidebar__link">Tutor's document</a>
                    </li>
<!--                    <li class="sidebar__item">
                        <a href="" class="sidebar__link">Account</a>
                    </li>-->
                </ul>
<!--                <ul class="sub-sidebar__list">
                    <li class="sub-sidebar__item">
                        <a href="" class="sub-sidebar__link">My Profile</a>
                    </li>
                    <li class="sub-sidebar__item">
                        <a href="" class="sub-sidebar__link">Settings</a>
                    </li>
                    <li class="sub-sidebar__item">
                        <a href="" class="sub-sidebar__link">Logout</a>
                    </li>
                </ul>-->
            </div>
            <div class="content">
                <h1 class="title">
                    Tutor's document
                </h1>
                <div style="overflow-x: auto;">
                    <table class="table table-color">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>File</th>
                                <th>Description</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($total_rows > 0 ): ?>
                                <?php while ($row = $res_data->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id']?></td>
                                    <td><?= $row['title']?></td>
                                    <td><?= str_replace("data/", "", $row['file_path']); ?></td>
                                    <td>
                                        <?= $row['description']?>
                                    </td>
                                    <td>
                                        <a href="<?= $row['file_path']?>" class="close" download>
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                    <h3>No document by your tutor</h3>
                            <?php endif; ?>
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