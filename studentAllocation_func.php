<?php
if(isset($_POST['allocate'])) {
    if(count($_POST['student']) > 0 && $_POST['student'] != null && isset($_POST['student'])) {
        echo count($_POST['student']);
        var_dump($_POST['teacher']);
        var_dump($_POST['student']);
    } else {
        //header('Refresh: 1; URL=studentAllocation_test.php');
        echo "<script>alert('No Student Selected')</script>";
        //header("Location: studentAllocation_test.php");
    }
    
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

