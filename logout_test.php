<?php 
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<html>
    <form action="logout_func.php" method="post">
        <input type="submit" value="Log Out">
    </form>
</html>
