<?php 
require 'functions.php';
session_start();
if(isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>

<html>
    <div>
        <h1>Log In Function</h1>
        <form action="login_func.php" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required> <br>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required> <br>
            <input type="submit" value="Submit">
        </form>
    </div>
</html>

