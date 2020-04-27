<?php
require './functions.php';
session_start();
checkUser(1);
if($_SESSION['role'] != 1 && $_SESSION['role'] != 2) {
    echo "<script>alert('Restricted Area');</script>";
    header('Refresh: 2; URL=index.php');
    echo "Redirecting ...";
}
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>File Upload</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
    <?php 
        if($_SESSION['role'] == 2) {
        ?>
            <form action="workSubmit_func.php" method="post" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="sender" value="<?= $_SESSION['uid']?>">

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


                Title<br>
                <input type="text" name="title" required> <br>
                File
                <input type="file" name="fileUpload" value=""> <br>
                Description
                <textarea name="description" form="uploadForm" placeholder="Enter description ..."></textarea>
                <input type="hidden" name="role" value="<?= $_SESSION['role']?>">
                <input type="submit" name="upload" value="Send">
            </form>
        <?php
        }
        if($_SESSION['role'] == 1) {
            ?>
            <form action="workSubmit_func.php" method="post" enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="sender" value="<?= $_SESSION['uid']?>">

                        <div class="studentSelect col-md-4">
                            <div class="form-group">
                                <label for="teacherSelect">Send file to student</label>
                                <select class="form-control" id="teacherSelect" name="receiver">
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
                        </div>

                Title<br>
                <input type="text" name="title" required> <br>
                File
                <input type="file" name="fileUpload" value=""> <br>
                Description
                <textarea name="description" form="uploadForm" placeholder="Enter description ..."></textarea>
                <input type="hidden" name="role" value="<?= $_SESSION['role']?>">
                <input type="submit" name="upload" value="Send">
            </form>
            <?php
        }
    ?>
    
    
</body>
</html>