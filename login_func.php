<?php
        
        require_once './functions.php';

        $error = $user = $pass = "";
        if ( isset ( $_POST[ 'username' ] ) )
        {
            $user = sanitizeString ( $_POST[ 'username' ] );
            $pass = sanitizeString ( $_POST[ 'password' ] );
            if ( $user == "" || $pass == "" )
            {
                // provide script for display html error for empty fields
            } else
            {
                $token = passwordToToken ( $pass );
                $result = queryMysql ( "SELECT * FROM users WHERE username = '$user' AND password = '$token' " );
                if ( $result->num_rows == 0 )
                {
                    // provide script for display html error for failed to log in
                    echo "<script>console.log('Log In Failed, Wrong username or password');</script>";
                    header("Location: login_test.php");
                } else
                {
                    session_start ();
                    $_SESSION[ 'uid' ] = mysqli_fetch_array ( $result )[ 0 ];
                    $_SESSION[ 'username' ] = $user;
                    $_SESSION[ 'password' ] = $pass;
                    $test = $_SESSION['role'] = mysqli_fetch_array(queryMysql ( "SELECT role_id FROM users WHERE username = '$user' " ))[0];
                    echo "<script>console.log('$test');</script>";
                    // Check role to redirect
                    header("Location: logout_test.php");
                }
            }
        }
?>


<!-- 
    Admin Account: admin - admin123
->
