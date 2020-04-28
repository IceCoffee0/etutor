<?php
require_once './dbconnect.php';
$salt1 = "$%^&";
$salt2 = "!@#$%";
//Connect to the DB
$connection = new mysqli($hostname, $username, $password, $database, $port);
if ($connection->connect_error) {
    die ($connection->connect_error);
}

//this is used to execute all SQL queries
function queryMysql($query) {
    global $connection;
    $result = $connection->query($query);
    if (!$result) {
        die ($connection->error);
    }
    return $result;
}

//this is for security purpose
function sanitizeString($str) {
    global $connection;
    $str = strip_tags($str); //remove html tags
    $str = htmlentities($str); //encode html (for special characters)
    if (get_magic_quotes_gpc()){
        $str = stripslashes($str); //Don't use the magic quotes
    }
    //Avoid MYSQL Injection
    $str = $connection->real_escape_string($str);
    return $str;
}

function destroySession() {
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time() - 42000,"/");
    }
    session_destroy();
}

//Convert password into encrypted form
function passwordToToken($password){
    global $salt1;
    global $salt2;
    $token = hash ("ripemd128", "$salt1$password$salt2");
    return $token;
}

//Add user to the database
function registerUser($fullname,$username, $password, $roleId, $email, $phone = null){
    //Setup one default user
    $result = queryMysql("SELECT * FROM users where username='$username'");
    $row = mysqli_fetch_assoc($result);
    if (!$row) { //user doesn't exist
        //Add a default user
        $token = passwordToToken($password);
        $query = "INSERT INTO users(fullname,username, password, role_id, email, phone) VALUES('$fullname','$username', '$token', '$roleId', '$email', '$phone')";
        queryMysql($query);
        return 1; //added
    }else {
        return 0; //not added
    }
}

function checkUser($level) {
    if(!isset($_SESSION['role']) || $_SESSION['role'] < $level) {
        header('Refresh: 2; URL=login_test.php');
        echo "<script>alert('Restricted Area')</script>";
        echo "Redirecting ...";
        return false;
    } else {
        return true;
    }
}


function generateAndSendAccount($name, $email, $role, $phone = null) {
    $username = generateRandomString($name, 8);
    $password = passwordToToken(generateRandomString($name, 12));
    
    $result = registerUser($name, $username, $password, $role, $email, $phone);
    if($result) {
        
        $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
        $to = '<' .  $email . '>';
        $subject = 'Your Loggin Credential';
        $message = "Hello, your account has been created on the eTutor system, plaease use the following credential to log in.\nUsername: " . $username . "\n" . "Passowrd: " . $password;
        $headers = 'From: ' . $from;

        if (!mail($to, $subject, $message, $headers))
        {
            echo "Error.";
            return false;
        }
        else
        {
            echo "Email sent.";
            return true;
        }
        
    } else {
        echo $result;
    }
    
}

function generateRandomString($name, $n) {
    $seed = $string = preg_replace('/\s+/', '', $name);
    $characters = '0123456789' . $seed; 
    $randomString = ''; 
  
    for ($i = 0; $i < $n; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
}

function getuserList($user) {
    $query = "SELECT * FROM users INNER JOIN role ON `users`.`role_id` = `role`.`role_id` WHERE `role`.`role_name` = '$user' ";
    return queryMysql($query);
}

function getUnAllocatedStudents() {
    $query = "SELECT allocated_students FROM allocation";
    $result = queryMysql($query);
    $list = array();
    while($row = $result->fetch_assoc()) {
        $list = array_merge($list, explode(",", $row['allocated_students']));
    }
    $query2 = "SELECT user_id, fullname FROM users WHERE role_id = 2";
    $result2 = queryMysql($query2);
    $students = array();
    while ($row = $result2->fetch_assoc()) {
        if(!in_array($row['user_id'], $list)) {
            array_push($students, $row);
        }
    }
    return $students;
}

function findEmails($ids) {
    $query = "SELECT email FROM users WHERE user_id in ('$ids')";
    $result = queryMysql($query);
    $emails = array();
    while ($row = $result->fetch_assoc()) {
        array_push($emails, $row['email']);
    }
    return $emails;
}

function getUserFullNameAndId($ids) {
    $query = "SELECT user_id,fullname FROM users WHERE user_id in ('$ids')";
    $result = queryMysql($query);
    $users = array();
    while ($row = $result->fetch_assoc()) {
        array_push($users, $row['fullname']. ' - ' .$row['user_id']);
    }
    return $users;
}

function findTutor($studentId) {
    $query = "SELECT * FROM allocation";
    $result = queryMysql($query);
    while($row = $result->fetch_assoc()) {
        $tutorId = $row['tutor_id'];
        $studentIds = explode(",", $row['allocated_students']);
        if(in_array($studentId, $studentIds)) {
            return $tutorId;
        }
    }
    return null;
}

function getTutorName($studentId) {
    $tutorId = findTutor($studentId);
    if($tutorId != null) {
        $tutorName = getUserFullNameAndId($tutorId);
        return $tutorName[0];
    } else {
        return null;
    }
}

function getTutorsStudent($tutorId) {
    $query = "SELECT * FROM allocation";
    $result = queryMysql($query);
    $students = array();
    while ($row = $result->fetch_assoc()) {
        if($row['tutor_id'] == $tutorId) {
            $studentIds = $row['allocated_students'];
            $query2 = "SELECT * FROM users WHERE user_id IN($studentIds)";
            $result2 = queryMysql($query2);
            while ($row2 = $result2->fetch_assoc()) {
                array_push($students, $row2);
            }
        }
    }
    return $students;
}

?>