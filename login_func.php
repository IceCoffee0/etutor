<?php
        
        require_once './functions.php';

        $error = $user = $pass = "";
        if ( isset ( $_POST[ 'username' ] ) )
        {
            $user = sanitizeString ( $_POST[ 'username' ] );
            $pass = sanitizeString ( $_POST[ 'password' ] );
            if ( $user == "" || $pass == "" )
            {
                echo "<script>alert('Fields must not be empty');</script>";
                echo "Redirecting ..";
                header("Refresh: 2; URL=index.php");
            } else
            {
                $token = passwordToToken ( $pass );
                $result = queryMysql ( "SELECT * FROM users WHERE username = '$user' AND password = '$token' " );
                if ( $result->num_rows == 0 )
                {
                    echo "<script>alert('Log In Failed, Wrong username or password');</script>";
                    echo "Redirecting ..";
                    header('Refresh: 2; URL=index.php');;
                } else
                {
                    session_start ();
                    $_SESSION[ 'uid' ] = mysqli_fetch_array ( $result )[ 0 ];
                    $_SESSION[ 'username' ] = $user;
                    $_SESSION[ 'password' ] = $pass;
                    $role = $_SESSION['role'] = mysqli_fetch_array(queryMysql ( "SELECT role_id FROM users WHERE username = '$user' " ))[0];
                    echo "<script>console.log('$role');</script>";
                    if($role == 1) {
                        header('Refresh: 1; URL=tutor_homepage.php');
                    } elseif($role == 2) {
                        header('Refresh: 1; URL=student_homepage.php');
                    } elseif($role == 3) {
                        header('Refresh: 1; URL=admin_panel.php');
                    } elseif($role == 4) {
                        header('Refresh: 1; URL=admin_panel.php');
                    } elseif($role == 5) {
                        header('Refresh: 1; URL=admin_panel.php');
                    }
                    echo "<script>alert('Log In Success');</script>";
                    echo "Redirecting ..";
                }
            }
        } else {
            echo "<script>alert('Fields must not be empty');</script>";
            echo "Redirecting ..";
            header("Refresh: 2; URL=index.php");
        }
?>


<!-- 
    Admin Account: admin - admin123
->
