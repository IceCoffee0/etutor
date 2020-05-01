<?php 
require 'functions.php';
session_start();
validateUser(3);
?>
<html>
    <div>
        <h1>Register Function</h1>
        <form action="register_func.php" method="post">
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
                        if($_SESSION['role'] == 3) {
                            if($row['role_id'] != 3 && $row['role_id'] != 4 && $row['role_id'] != 5) {
                                ?>
                                    <option value='<?= $row['role_id']?>'> <?= $row['role_name']?> </option>
                                <?php
                            }
                        } elseif($_SESSION['role_id' == 4]) {
                            if($row['role_id'] != 4 && $row['role_id'] != 5) {
                                ?>
                                    <option value='<?= $row['role_id']?>'> <?= $row['role_name']?> </option>
                                <?php
                            }
                        }
                    };
                ?>
            </select> <br>
            <input type="hidden" name="user" value="<?= $_SESSION['uid']?>">
            <input type="submit" value="Submit">
        </form>
    </div>
</html>
