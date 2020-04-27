<?php
require './activityManager.php';

if (isset($_POST['upload']) && isset($_FILES['fileUpload'])) {
    if ($_FILES['fileUpload']['error'] > 0) {
        echo "Upload Failed";
    } else {
        $title = sanitizeString($_POST['title']);
        $sender = $_POST['sender'];
        $receiver = $_POST['receiver'];
        $description = sanitizeString($_POST['description']);
        $path = 'data/' . $_FILES['fileUpload']['name'];
        if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $path)){
            $query = "INSERT INTO file_upload(title,sender,receiver,file_path,description) VALUES('$title', '$sender', '$receiver', '$path', '$description')";
            if(queryMysql($query)) {
                echo "Upload success";
                if($_POST['role'] == 1) {
                    recordActivity($sender, 6, "$receiver");
                    // add redirect laater
                } elseif($_POST['role'] == 2) {
                    recordActivity($sender, 4);
                    // add redirect laater
                }
            }
        }
        
    }
}


