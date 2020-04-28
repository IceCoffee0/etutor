<?php 
    require './activityManager.php';
    session_start();
    $authorized = checkUser(1);
    
    if($authorized == true) {
        $page = "student_assignment.php";
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

        if($role == 1) {
            $total_pages_sql = "SELECT COUNT(*) FROM file_upload WHERE receiver = '$userId'";
            $result = queryMysql($total_pages_sql);
            $total_rows = $result->fetch_array()[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $sql = "SELECT * FROM file_upload WHERE receiver = '$userId' LIMIT $offset, $no_of_records_per_page";
            $res_data = queryMysql($sql);
        } 
        else if($role == 2 && $tutorId !== null) {
            $total_pages_sql = "SELECT COUNT(*) FROM file_upload WHERE sender = '$userId' AND receiver = '$tutorId'";
            $result = queryMysql($total_pages_sql);
            $total_rows = $result->fetch_array()[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);

            $sql = "SELECT * FROM file_upload WHERE sender = '$userId' AND receiver = '$tutorId' LIMIT $offset, $no_of_records_per_page";
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
                            <a href="student_assignment.php" class="sidebar-mobile__link">Student submission</a>
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
                        <a href="student_assignment.php" class="sidebar__link">Student submission</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="content">
                <h1 class="title">
                    Work and report submission
                </h1>
                <div class="function">
                    <?php if($role == 2):?>
                    <div class="function__list">
                        <button class="function__item" data-toggle="modal" data-target="#submitModal">New Submission</button>
                    </div>
                    <?php elseif($role == 1): ?>
                    <div class="function__list">
                        <button class="function__item" data-toggle="modal" data-target="#sendModal">Send document to student </button>
                    </div>
                    <?php endif; ?>
                </div>
                <div style="overflow-x: auto;">
                    <table class="table table-color">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Sender</th>
                                <th>Title</th>
                                <th>File</th>
                                <th>Reviewed</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($total_rows > 0 ): ?>
                                <?php while ($row = $res_data->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id']?></td>
                                    <td>
                                        <?php 
                                            echo getUserFullNameAndId($row['sender'])[0];
                                        ?>
                                    </td>
                                    <td><?= $row['title']?></td>
                                    <td><?= str_replace("data/", "", $row['file_path']); ?></td>
                                    <td>
                                        <input type="checkbox" disabled class="checkbox" <?php if($row['feedback'] !== null || $row['feedback'] != "") {echo "checked";}?>>
                                    </td>
                                    <td>
                                        <form action="submitdetail.php" method="get">
                                            <input type="hidden" name="smid" value="<?= $row['id']?>">
                                            <button type="submit"><i class="fas fa-eye"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                    <h3>No submission yet</h3>
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
    
    <?php if($role == 2):?>
    <div class="modal fade" id="submitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Submit report</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="workSubmit_func.php" method="post" enctype="multipart/form-data" id="uploadForm">
            <div class="modal-body">
                <input type="hidden" name="sender" value="<?= $_SESSION['uid']?>">
                <input type="hidden" name="role" value="<?= $role ?>">
                <input type="hidden" name="page" value="<?= $page ?>">
                <?php 
                    $query = "SELECT * FROM allocation";
                    $result = queryMysql($query);
                    while($row = $result->fetch_assoc()) {
                        $teacher = $row['tutor_id'];
                        $students = explode(",", $row['allocated_students']);
                        if(in_array($_SESSION['uid'], $students)) {
                            ?>
                            <input type="hidden" name="receiver" value="<?= $teacher ?>">
                            <?php
                        }
                    }
                ?>
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" class="form-control" name="title" id="inputTitle" >
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="file">File</label>
                      <input type="file" name="fileUpload" value="">
                    </div>
                </div>

                <div class="form-group">
                      <label for="desc">Description</label>
                      <textarea class="form-control" id="desc" rows="3" name="description" form="uploadForm"></textarea>
                </div>
                            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info" name="upload" value="Submit">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <?php elseif ($role == 1):?>
    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Send document to students</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="workSubmit_func.php" method="post" enctype="multipart/form-data" id="uploadForm">
            <div class="modal-body">
                <input type="hidden" name="sender" value="<?= $_SESSION['uid']?>">
                <input type="hidden" name="role" value="<?= $role ?>">
                <input type="hidden" name="page" value="<?= $page ?>">
                        
                            <div class="form-group">
                                <label for="teacherSelect">Send file to student</label>
                                <select class="form-control" id="studentSelect" name="receiver">
                                    <?php
                                        $tutorId = $_SESSION['uid'];
                                        $query1 = "SELECT allocated_students FROM allocation WHERE tutor_id = '$tutorId'";
                                        $result1 = queryMysql($query1);
                                        $students = $result1->fetch_array()[0];
                                        $query2 = "SELECT * FROM users WHERE user_id IN ($students)";
                                        $result2 = queryMysql($query2);
                                        while($row = $result2->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['user_id']?>"> <?= $row['fullname']?> </option>
                                        <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" class="form-control" name="title" id="inputTitle" >
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="file">File</label>
                      <input type="file" name="fileUpload" value="">
                    </div>
                </div>

                <div class="form-group">
                      <label for="desc">Description</label>
                      <textarea class="form-control" id="desc" rows="3" name="description" form="uploadForm"></textarea>
                </div>
                            
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-info" name="upload" value="Submit">Submit</button>
            </div>
            </form>
          </div>
        </div>
    </div>
    <?php endif; ?>
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