<?php
require './activityManager.php';

if (isset($_POST['upload']) && isset($_FILES['fileUpload'])) {
    if ($_FILES['fileUpload']['error'] > 0) {
        echo "Upload Failed";
    } else {
        $title = sanitizeString($_POST['title']);
        $sender = sanitizeString($_POST['sender']);
        $receiver = sanitizeString($_POST['receiver']);
        $page = sanitizeString($_POST['page']);
        $description = sanitizeString($_POST['description']);
        $path = 'data/' . $_FILES['fileUpload']['name'];
        if(move_uploaded_file($_FILES['fileUpload']['tmp_name'], $path)){
            $query = "INSERT INTO file_upload(title,sender,receiver,file_path,description) VALUES('$title', '$sender', '$receiver', '$path', '$description')";
            if(queryMysql($query)) {
                echo "Upload success \n";
                if($_POST['role'] == 1) {
                    recordActivity($sender, 6, "$receiver");
                    echo "Redirecting ...";
                    header("Refresh: 1; URL=$page");
                } elseif($_POST['role'] == 2) {
                    recordActivity($sender, 4);
                    echo "Redirecting ...";
                    header("Refresh: 1; URL=$page");
                }
            }
        }
        
    }
}


