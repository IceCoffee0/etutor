<?php
require './functions.php';
session_start();
checkUser(3); // Level: Staff or higher
?>
<head>
    <title>Manage Students</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>

<?php
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }
    $no_of_records_per_page = 5;
    $offset = ($pageno-1) * $no_of_records_per_page;

    $total_pages_sql = "SELECT COUNT(*) FROM users WHERE role_id = 2";
    $result = queryMysql($total_pages_sql);
    $total_rows = $result->fetch_array()[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);

    $sql = "SELECT * FROM users WHERE role_id = 2 LIMIT $offset, $no_of_records_per_page";
    $res_data = queryMysql($sql);
?>
    <row>
        <div class="col-md-4">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $res_data->fetch_assoc()){
                        ?>
                            <tr>
                                <td><?= $row['user_id']?></td>
                                <td><?= $row['fullname']?></td>
                                <td>
                                    <div>
                                        
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#user<?= $row['user_id']?>">
                                          ReAllocate
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="user<?= $row['user_id']?>" tabindex="-1" role="dialog">
                                          <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">ReAllocate Student</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                                <form action="studentAllocation_func.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="student" value="<?= $row['user_id']?>">
                                                    <h4><p>Student: <?= $row['fullname'] ?> - <?= $row['user_id']?></p></h4>
                                                    <div class="teacherSelect">
                                                        <div class="form-group">
                                                            <label for="teacherSelect">Re-Allocate This Student To Teacher</label>
                                                            <select class="form-control" id="teacherSelect" name="teacher">
                                                              <?php 
                                                                $teachers = getuserList("tutor");
                                                                while($row = $teachers->fetch_assoc()) {
                                                                    ?>
                                                                        <option value="<?= $row['user_id']?>"> <?= $row['fullname']?> </option>
                                                                    <?php
                                                                }
                                                              ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                  <input type="hidden" name="user" value="<?= $_SESSION['uid']?>">
                                                  <input type="submit" name="reAllocate" value="Save" class="btn btn-primary">
                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                                </form>
                                            </div>
                                          </div>
                                        </div>
                                        
                                    </div>
                                </td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </row>
    <row>
        <div class="col-md-4">
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
    </row>
</body>
