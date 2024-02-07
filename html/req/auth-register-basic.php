<?php
    $firstname      = $_POST['firstname'];
    $lastname       = $_POST['lastname'];
    $email          = $_POST['email'];
    $username       = $_POST['username'];
    $phonenumber    = $_POST['phonenumber'];
    $password       = $_POST['password'];
    $roles          = $_POST['roles'];
    $defaultradio1  = $_POST['default-radio-1'];

    if ($firstname)
        echo "is firstname $firstname, $lastname, 
                $username, $phonenumber, $password, 
                $roles, $defaultradio1, $email";
    else 
        echo 'is null';

    if ($firstname && $lastname && $username &&
        $phonenumber && $password && $roles && 
        $defaultradio1 && $email) {
        
        include "../connection/connection_db.php";
        
        // encode password
        $password = password_hash($password, PASSWORD_DEFAULT);

        // check if the user already exists
        $sql_check = "SELECT * FROM users WHERE username = ? AND pwd = ? AND email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$username, $password, $email]);

        if ($stmt_check->rowCount() > 0) {
           $em  = "The users already exists";
           header("Location: ../auth-register-basic.php?error=$em");
           exit;
        }else {
          $sql  = "INSERT INTO
                 users(firstname, lastname, email, username, phone_number, pwd, roles, gender)
                 VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->execute([$firstname, $lastname, $email, 
                         $username, $phonenumber, $password, 
                         $roles, $defaultradio1]);
          $sm = "New users created successfully";
          header("Location: ../auth-login-basic.php?success=$sm");
          exit;
        }

    } else {
        header("Location: ../auth-register-basic.php");
	    exit;
    }

?>