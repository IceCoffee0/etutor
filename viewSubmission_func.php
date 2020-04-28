<?php
require './activityManager.php';

if(isset($_POST['saveSubmit'])) {
    $user = $_POST['user'];
    $role = $_POST['role'];
    $smid = $_POST['smid'];
    if($role == 1) {
        $feedback = sanitizeString($_POST['feedback']);
        $query = "UPDATE file_upload SET feedback = '$feedback' WHERE id = '$smid'";
        if(queryMysql($query)) {
            echo "success";
            $query = "SELECT sender FROM file_upload WHERE id='$smid'";
            $user = queryMysql($query)->fetch_array()[0];
            recordActivity($user, 5, $target, $smid);
            header('Refresh: 1; URL=student_assignment.php');
            echo "Redirecting ...";
        } else {
            echo "failed";
            header('Refresh: 10; URL=student_assignment.php');
            echo "Redirecting ...";
        }
    } elseif($role == 2) {
        $title = sanitizeString($_POST['title']);
        $description = sanitizeString($_POST['desc']);
        $query = "UPDATE file_upload SET title = '$title', description = '$description' WHERE id = '$smid'";
        if(queryMysql($query)) {
            echo "success";
            header('Refresh: 1; URL=student_assignment.php');
            echo "Redirecting ...";
        } else {
            echo "failed";
            header('Refresh: 10; URL=student_assignment.php');
            echo "Redirecting ...";
        }
    }
}