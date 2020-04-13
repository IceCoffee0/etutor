<?php
require_once 'functions.php';
destroySession();
header("Location: index.php");
die("You've logged out, <a href='index.html'>click here</a> to continue!");
?>


