<?php
require './functions.php';
session_start();
checkUser(1);
$userId = $_SESSION['uid'];
$role = $_SESSION['role'];
$tutorId = null;
if(isset($_GET['smid'])) {
    $smid = $_GET['smid'];
}
?>

<head>
    <title>View submission detail</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/e76434167d.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
        $query = "SELECT * FROM file_upload WHERE id = '$smid'";
        $result = queryMysql($query);
        $row = $result->fetch_assoc();
    ?>
    <div class="col-md-6">
        <form action="viewSubmission_func.php" method="post" id="viewSubmit">
            <input type="hidden" name="role" value="<?= $role?>">
            <input type="hidden" name="smid" value="<?= $smid?>">
            <div class="form-group">
              <label for="inputTitle">Title</label>
              <input type="text" class="form-control" name="title" id="inputTitle" value="<?= $row['title']?>" <?php if($role != 2) {echo "readonly";}?> >
            </div>
            
            <div class="form-group">
              <label for="sender">Sender</label>
              <input type="text" class="form-control" id="sender" value="<?= getUserFullNameAndId($row['sender'])[0]?>" readonly>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="file">File</label>
                <input type="text" class="form-control" id="file" placeholder="<?= str_replace("data/", "", $row['file_path']); ?>" disabled>
                <input type="hidden" name="filepath" value="<?= $row['file_path']?>">
              </div>
              <div class="form-group col-md-6">
                  <label for="downloadbnt">Action</label> <br>
                  <a id="downloadbtn" class="btn btn-success" href="<?= $row['file_path']?>" download>Download</a>
              </div>
            </div>

            <div class="form-group">
                <label for="desc">Description</label>
                <textarea class="form-control" id="desc" rows="3" name="desc" form="viewSubmit" <?php if($role != 2) {echo "readonly";}?> ><?= $row['description']?></textarea>
            </div>
            <div class="form-group">
                <label for="feedback">Feedback</label>
                <textarea class="form-control" id="feedback" rows="3" name="feedback" form="viewSubmit" <?php if($role != 1) {echo "readonly";} ?> ><?= $row['feedback']?></textarea>
            </div>

            <button type="submit" name="saveSubmit" value="save" class="btn btn-primary">Save</button>
            <a class="btn btn-secondary" href="viewSubmission_test.php">Back</a>
        </form>
    </div>
</body>