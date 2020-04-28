<?php
//require './functions.php';
require './activityManager.php';
error_reporting(E_ERROR | E_PARSE);
$user = $_POST['user'];

if(isset($_POST['allocate'])) {
    if(count($_POST['student']) > 0 && $_POST['student'] != null && isset($_POST['student'])) {
        $teacherId = $_POST['teacher'];
        $studentIdArr = $_POST['student'];
        $studentIds = implode(",", $studentIdArr);
        $target = "$teacherId,$studentIds";
        //echo "Teacher ID: " . $teacherId . " Student IDs: " . $studentIds;
        allocateStudent($teacherId, $studentIds);
        recordActivity($_POST['user'], 2, $target);
        header('Refresh: 1; URL=admin_account_student.php');
        echo "Redirecting ...";
    } else {
        header('Refresh: 3; URL=admin_account_student.php');
        echo "<script>alert('No Student Selected')</script>";
        echo "Redirecting ...";
    }
}

if(isset($_POST['reAllocate'])) {
    if(isset($_POST['student']) && isset($_POST['teacher'])) {
        $teacherIdNew = $_POST['teacher'];
        $studentId = $_POST['student'];
        $teacherIdOld = null;
        $query = "SELECT * FROM allocation";
        $result = queryMysql($query);
        while($row = $result->fetch_assoc()) {
            $teacher = $row['tutor_id'];
            $students = explode(",", $row['allocated_students']);
            if(in_array($studentId, $students)) {
                $teacherIdOld = $teacher;
                if($teacherIdOld != $teacherIdNew) {
                    unAllocateStudent($teacher, $studentId);
                }
            }
        }
        if($teacherIdOld != $teacherIdNew) {
            if(allocateStudent($teacherIdNew, $studentId, $reAllocation = true, $teacherIdOld)) {
                $query1 = "SELECT allocated_students FROM allocation WHERE tutor_id = '$teacherIdOld'";
                $query2 = "DELETE FROM allocation WHERE tutor_id = '$teacherIdOld'";
                $result = queryMysql($query1);
                if($result->fetch_array()[0] == "") {
                    queryMysql($query2);
                }
            }
            $target = "$teacherIdOld,$teacherIdNew,$studentId";
            recordActivity($user, 3, $target);
            header('Refresh: 1; URL=admin_account_student.php');
            echo "Redirecting ...";
        } else {
            echo "<script>alert('Student already allocated to this teacher');</script>";
            header('Refresh: 2; URL=admin_account_student.php');
            echo "Redirecting ...";
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

function allocateStudent($teacherId, $studentIds, $reAllocation = false, $teacherIdOld = null) {
    if(checkTeacherExist($teacherId)) {
        $query = "SELECT allocated_students FROM allocation WHERE tutor_id = '$teacherId'";
        $result = queryMysql($query);
        while($row = $result->fetch_assoc()) {
            $studentIdsCurrent = explode(",", $row['allocated_students']); 
        }
        $studentIdsNew = implode(",",array_merge($studentIdsCurrent, explode(",", $studentIds)));
        $query = "UPDATE allocation SET allocated_students = '$studentIdsNew' WHERE tutor_id = '$teacherId'";
        if(queryMysql($query) && $reAllocation == false) {
            
            $teacherMail = findEmails($teacherId)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherMail . '>';
            $subject = 'New student allocated';
            $message = "The student(s) with the following ID have been allocated to you: " . implode(",",getUserFullNameAndId($studentIds));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $studentMail = implode(",", findEmails($studentIds));
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '' . $studentMail;
            $subject = 'You have been allocated to a new teacher';
            $message = "You have been allocated to a new teacher with the following ID" . implode(",",getUserFullNameAndId($teacherId));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
        }
    } else {
        $query = "INSERT INTO allocation(tutor_id, allocated_students) VALUES('$teacherId','$studentIds')";
        if(queryMysql($query) && $reAllocation == false) {
            $teacherMail = findEmails($teacherId)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherMail . '>';
            $subject = 'New student allocated';
            $message = "The student(s) with the following ID have been allocated to you: " . implode(",",getUserFullNameAndId($studentIds));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $studentMail = implode(",", findEmails($studentIds));
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '' . $studentMail;
            $subject = 'You have been allocated to a new teacher';
            $message = "You have been allocated to a new teacher with the following ID: " . implode(",",getUserFullNameAndId($teacherId));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
        }
    }
    if($reAllocation == true) {
            $teacherNewMail = findEmails($teacherId)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherNewMail . '>';
            $subject = 'New Student Allocated';
            $message = "The student with the following ID have been allocated to you: " . implode(",", getUserFullNameAndId($studentIds));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $teacherOldMail = findEmails($teacherIdOld)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $teacherOldMail . '>';
            $subject = 'Student Re-allocated';
            $message = "The student with the following ID have been Re-allocated: " . implode(",", getUserFullNameAndId($studentIds));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            $studentMail = findEmails($studentIds)[0];
            $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
            $to = '<' .  $studentMail . '>';
            $subject = 'Re-allocation';
            $message = "You have been Re-allocated to a new teacher: " . implode(",", getUserFullNameAndId($teacherId));
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
            
            return true;
    }
}