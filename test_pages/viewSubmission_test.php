<?php
require './functions.php';
session_start();
validateUser(1);
$userId = $_SESSION['uid'];
$role = $_SESSION['role'];
$tutorId = null;
if($role == 2) {
    $tutorId = findTutor($userId);
}
?>

<head>
    <title>View submission</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e76434167d.js" crossorigin="anonymous"></script>
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
    
?>
    
    <row>
        <table class="table table-bordered col-md-6">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Sender</th>
                    <th scope="col">Title</th>
                    <th scope="col">File</th>
                    <th scope="col">Marked</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = $res_data->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row['id']?></td>
                        <td>
                            <?php 
                                echo getUserFullNameAndId($row['sender'])[0];
                            ?>
                        </td>
                        <td><?= $row['title']?></td>
                        <td><?= str_replace("data/", "", $row['file_path']); ?></td>
                        <td><input type="checkbox" disabled <?php if($row['feedback'] !== null || $row['feedback'] != "") {echo "checked";}?>></td>
                        <td>
                            <div>
                                <a class="btn btn-default" href="<?= $row['file_path']?>" download><i class="fas fa-download"></i></a>
                                <form action="viewSubmitDetail_test.php" method="get">
                                    <input type="hidden" name="smid" value="<?= $row['id']?>">
                                    <button class="btn btn-default" type="submit"><i class="far fa-eye"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </row>

    <row>
        <div class="col-md-6">
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