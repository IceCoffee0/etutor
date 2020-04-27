<?php
     require_once './functions.php';
     $students = getUnAllocatedStudents();
     $caigido = count($students);
     echo 'Số sinh viên chưa có giáo viên là: ' .$caigido;
 
 
    function getUnAllocatedTutor() {
    $query = "SELECT tutor_id FROM allocation";
    $result = queryMysql($query);
    $list = array();
    while($row = $result->fetch_assoc()) {
        $list = array_merge($list, explode(",", $row['tutor_id']));
    }
    $query2 = "SELECT user_id, fullname FROM users WHERE role_id = 1";
    $result2 = queryMysql($query2);
    $tutor = array();
    while ($row = $result2->fetch_assoc()) {
        if(!in_array($row['user_id'], $list)) {
            array_push($tutor, $row);
        }
    }
    return $tutor;
        }
        
    $tutor = getUnAllocatedTutor();
    $cainayne = count($tutor);
 
    echo 'Số giáo viên chưa có sinh viên là : ' .$cainayne;
 
    function getStudentUploadedFile() {
    $counter = 0;
    $query = "SELECT user_id FROM users WHERE role_id = 2";
    $result2 = queryMysql($query);
    $studentsUploaded = array();
    while ($row = $result2->fetch_assoc()) {
            array_push($studentsUploaded, $row['user_id']);
        }
 
    $query2 = "SELECT sender FROM file_upload";
    $result = queryMysql($query2);
    $list = array();
        while($row = $result->fetch_assoc()) {
                if(in_array($row['sender'], $studentsUploaded)) 
                {
                        $counter++;
                }  
            }
         return $counter;
    }
         $num = getStudentUploadedFile();
     echo 'Số file được upload bởi sinh viên là: ' . $num;
?>
