<?php 
require './functions.php'; 

if(isset($_POST['fullname'])) {
    $fullname = sanitizeString($_POST['fullname']);
    $email = sanitizeString($_POST['email']);
    $role = sanitizeString($_POST['role']);
    
    generateAndSendAccount($fullname, $email, $role);
}

?>
