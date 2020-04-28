<?php 
//require './functions.php';
require './activityManager.php';

if(isset($_POST['adduser'])) {
    $fullname = sanitizeString($_POST['fullname']);
    $email = sanitizeString($_POST['email']);
    $role = sanitizeString($_POST['role']);
    $phone = sanitizeString($_POST['phone']);
    $thisPage = sanitizeString($_POST['page']);
    $initiator = sanitizeString($_POST['user']);
    if(generateAndSendAccount($fullname, $email, $role)) {
        $query = "SELECT user_id FROM users WHERE fullname = '$fullname'";
        $target = queryMysql($query)->fetch_array()[0];
        recordActivity($initiator, 1, $target);
        header("Location: $thisPage");
    }   
}

if(isset($_POST['edituser'])) {
    $fullname = sanitizeString($_POST['fullname']);
    $email = sanitizeString($_POST['email']);
    $role = sanitizeString($_POST['role']);
    $phone = sanitizeString($_POST['phone']);
    $thisPage = sanitizeString($_POST['page']);
    $initiator = sanitizeString($_POST['user']);
    $userId = sanitizeString($_POST['userid']);
    
    $query = "UPDATE users SET fullname = '$fullname', email = '$email', phone = '$phone' WHERE user_id = '$userId'";
    if(queryMysql($query)) {
        header("Location: $thisPage");
    } else {
        echo "<script>alert('Error occurred');</script>";
        header("Refresh: 2; URL=$thisPage");
    }
}

?>
