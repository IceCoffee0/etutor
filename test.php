<?php 
require './functions.php'; 

if(isset($_POST['fullname'])) {
    $fullname = sanitizeString($_POST['fullname']);
    $email = sanitizeString($_POST['email']);
    $role = sanitizeString($_POST['role']);
    
    generateAndSendAccount($fullname, $email);
}

?>


<html>
    <div>
        <h1>Register Function</h1>
        <form action="test.php" method="post">
            <label for="fullname">Full Name: </label>
            <input type="text" id="fullname" name="fullname" required> <br>
            <label for="eamil">Email: </label>
            <input type="email" id="email" name="email" required> <br>
            <label for="role">Role</label>
            <select id="role" name="role">
                <?php 
                    $query = "SELECT * FROM role";
                    $role = queryMysql($query);
                    while ($row = $role->fetch_assoc()) {
                        if($row['role_id'] != 5) {
                        ?>
                        <option value='<?= $row['role_id']?>'> <?= $row['role_name']?> </option>
                        <?php
                        }
                    };
                ?>
            </select> <br>
            <input type="submit" value="Submit">
        </form>
    </div>
</html>
