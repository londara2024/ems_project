<?php
    session_start();

    $email_username = $_POST['email-username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    echo "Email OR Username [ $email_username ], password [ $password ], role [ $role ]";

    if ($email_username && $password) {

        include "../connection/connection_db.php";
        // $table = "";
        // if ($role == "Admin") {
            // $table = "users";
        // } else if ($role == "Student") {
        //     $table = "student";
        // }
        
        if (preg_match('/^\S+@\S+\.\S+$/', $email_username)) {
            // when user input email
            $sql_query = "SELECT * FROM users WHERE email = ?";
        } else {
            $sql_query = "SELECT * FROM users WHERE username = ?";
        }

        $stmt = $conn->prepare($sql_query);
        $stmt->execute([$email_username]);

        if ($stmt->rowCount() == 1) {

            $user   = $stmt->fetch();

            $uname  = $user['username'];
            $email  = $user['email'];
            $pwd    = $user['pwd'];
            $role   = $user['roles'];

            echo "$uname, $pwd, $email";

            if (password_verify($password, $pwd)) {
                echo " === > Message :: password correct";
                $_SESSION['role'] = $role;
                header("Location: ../index.php");
                exit;
            } 
            // else {
            //     $em = "password connot verify";
            //     header("Location: ../auth-login-basic.php?error=$em&$table");
            // }

        } else {
            echo "No Data, [$sql_query]";
            $em = "Email or Username and password Incorrect";
            header("Location: ../auth-login-basic.php?error=$em");
        }

    } else {
        $em = "Email or Username and password not enter";
        header("Location: ../auth-login-basic.php?error=$em");
    }

?>