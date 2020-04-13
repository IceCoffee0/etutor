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
    $role = $_SESSION['role'];
    if(!isset($_SESSION['role']) || $_SESSION['role'] != $level) {
        echo "<script>alert('Restricted Area');</script>";
        header("Location: login.php");
    }
}

function generateAndSendAccount($name, $email, $role) {
    $username = generateRandomString($name, 8);
    $password = passwordToToken(generateRandomString($name, 12));
    
    $result = registerUser($name, $username, $password, $role, $email);
    if($result) {
        
        $from = 'Ngo Manh Duy <duynmgch16457@fpt.edu.vn>';
        $to = 'Emperor <' .  $email . '>';
        $subject = 'Your Loggin Credential';
        $message = "Username: " . $username . "\n" . "Passowrd: " . $password;
        $headers = 'From: ' . $from;

        if (!mail($to, $subject, $message, $headers))
        {
            echo "Error.";
        }
        else
        {
            echo "Email sent.";
            header("Location: login_test.php");
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

?>