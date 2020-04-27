<?php 
//require './functions.php';
require './activityManager.php';

if(isset($_POST['fullname'])) {
    $fullname = sanitizeString($_POST['fullname']);
    $email = sanitizeString($_POST['email']);
    $role = sanitizeString($_POST['role']);
    $initiator = $_POST['user'];
    if(generateAndSendAccount($fullname, $email, $role)) {
        $query = "SELECT user_id FROM users WHERE fullname = '$fullname'";
        $target = queryMysql($query)->fetch_array()[0];
        recordActivity($initiator, 1, $target);
        header("Location: index.php");
    }
    
}

?>
