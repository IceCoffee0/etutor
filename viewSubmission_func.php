<?php
require './functions.php';

if(isset($_POST['saveSubmit'])) {
    $role = $_POST['role'];
    $smid = $_POST['smid'];
    if($role == 1) {
        $feedback = sanitizeString($_POST['feedback']);
        $query = "UPDATE file_upload SET feedback = '$feedback' WHERE id = '$smid'";
        if(queryMysql($query)) {
            echo "success";
            header('Refresh: 1; URL=viewSubmission_test.php');
            echo "Redirecting ...";
        } else {
            echo "failed";
            header('Refresh: 10; URL=viewSubmission_test.php');
            echo "Redirecting ...";
        }
    } elseif($role == 2) {
        $title = sanitizeString($_POST['title']);
        $description = sanitizeString($_POST['desc']);
        $query = "UPDATE file_upload SET title = '$title', description = '$description' WHERE id = '$smid'";
        if(queryMysql($query)) {
            echo "success";
            header('Refresh: 1; URL=viewSubmission_test.php');
            echo "Redirecting ...";
        } else {
            echo "failed";
            header('Refresh: 10; URL=viewSubmission_test.php');
            echo "Redirecting ...";
        }
    }
}