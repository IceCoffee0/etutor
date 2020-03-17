<?php

require './functions.php';


$query = "SELECT * FROM role";
$result = queryMysql($query);
while ($row = $result->fetch_assoc()) {
    echo "Role Id: " . $row['role_id'] . " " ."Role Name: ". $row["role_name"] . "<br>";
};




