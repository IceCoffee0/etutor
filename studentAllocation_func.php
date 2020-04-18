<?php
require './functions.php';
error_reporting(E_ERROR | E_PARSE);

if(isset($_POST['allocate'])) {
    if(count($_POST['student']) > 0 && $_POST['student'] != null && isset($_POST['student'])) {
        $teacherId = $_POST['teacher'];
        $studentIdArr = $_POST['student'];
        $studentIds = implode(",", $studentIdArr);
        //echo "Teacher ID: " . $teacherId . " Student IDs: " . $studentIds;
        allocateStudent($teacherId, $studentIds);
        header('Refresh: 1; URL=studentAllocation_test.php');
        echo "Redirecting ...";
    } else {
        header('Refresh: 3; URL=studentAllocation_test.php');
        echo "<script>alert('No Student Selected')</script>";
        echo "Redirecting ...";
    }
}

if(isset($_POST['reAllocate'])) {
    if(isset($_POST['student']) && isset($_POST['teacherOld'])) {
        $teacherIdOld = $_POST['teacherOld'];
        $teacherIdNew = $_POST['teacherNew'];
        $studentId = $_POST['student'];
        if(unAllocateStudent($teacherIdOld, $studentId)) {
            allocateStudent($teacherIdNew, $studentId);
        }
    }
}

function unAllocateStudent($teacherId, $studentId) {
    $query = "SELECT allocated_students FROM allocation WHERE tutor_id = '$teacherId'";
    $result = queryMysql($query);
    while ($row = $result->fetch_assoc()) {
        $studentIds = explode(",", $row['allocated_students']);
    }
    for($i = 0; $i < count($studentIds); $i++) {
        if($studentIds[$i] == $studentId) {
            unset($studentIds[$i]);
        }
    }
    $newStudentIds = implode(",", $studentIds);
    $query = "UPDATE allocation SET allocated_students = '$newStudentIds' WHERE tutor_id = '$teacherId'";
    if(queryMysql($query)) {
        return true;
    } else {
        return false;
    }
}

function checkTeacherExist($id) {
    $query = "SELECT tutor_id FROM allocation WHERE tutor_id = '$id'";
    $result = queryMysql($query);
    if($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function allocateStudent($teacherId, $studentIds) {
    if(checkTeacherExist($teacherId)) {
        $query = "SELECT allocated_students FROM allocation WHERE tutor_id = '$teacherId'";
        $result = queryMysql($query);
        while($row = $result->fetch_assoc()) {
            $studentIdsCurrent = explode(",", $row['allocated_students']); 
        }
        $studentIdsNew = implode(",",array_merge($studentIdsCurrent, explode(",", $studentIds)));
        $query = "UPDATE allocation SET allocated_students = '$studentIdsNew' WHERE tutor_id = '$teacherId'";
        if(queryMysql($query)) {
            
            $teacherMail = findEmails($teacherId)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherMail . '>';
            $subject = 'New student allocated';
            $message = "The student(s) with the following ID have been allocated to you: " . $studentIds;
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $studentMail = implode(",", findEmails($studentIds));
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '' . $studentMail;
            $subject = 'You have been allocated to a new teacher';
            $message = "You have been allocated to a new teacher with the following ID" . $teacherId;
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
        }
    } else {
        $query = "INSERT INTO allocation(tutor_id, allocated_students) VALUES('$teacherId','$studentIds')";
        if(queryMysql($query)) {
            $teacherMail = findEmails($teacherId)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherMail . '>';
            $subject = 'New student allocated';
            $message = "The student(s) with the following ID have been allocated to you: " . $studentIds;
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $studentMail = implode(",", findEmails($studentIds));
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '' . $studentMail;
            $subject = 'You have been allocated to a new teacher';
            $message = "You have been allocated to a new teacher with the following ID" . $teacherId;
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
        }
    }
}