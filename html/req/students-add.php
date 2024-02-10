<?php

    $firstname      = $_POST['firstname'];
    $lastname       = $_POST['lastname'];
    $username       = $_POST['username'];
    $phonenumber    = $_POST['phonenumber'];
    $password       = $_POST['password'];
    $email          = $_POST['email'];
    $roles          = $_POST['roles'];
    $gender         = $_POST['gender'];
    $classes        = $_POST['classes'];
    $subject        = $_POST['subject'];
    $grade          = $_POST['grade'];


    echo "$firstname, $lastname, $username, $gender
            $phonenumber, $password, $email, $roles, 
            $classes, $subject, $grade";



    if ($firstname && $lastname && $username && 
        $phonenumber && $password && $email && $roles && 
        $classes && $subject && $grade) {

        include "../connection/connection_db.php";

       // check if the user already exists
       $sql_check = "SELECT * FROM users WHERE username = ? AND pwd = ? AND email = ?";
       $stmt_check = $conn->prepare($sql_check);
       $stmt_check->execute([$username, $password, $email]);

       if ($stmt_check->rowCount() > 0) {
          $em  = "The users already exists";
          header("Location: ../students-add.php?error=$em");
          exit;
       }else {

            // encode password
            $pass = password_hash($password, PASSWORD_DEFAULT);

            // insert into user
            $sql  = "INSERT INTO
                users(firstname, lastname, email, username, phone_number, pwd, roles, gender)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$firstname, $lastname, $email, 
                        $username, $phonenumber, $pass, 
                        $roles, $gender]);
        

            // insert into student
            $sqlQuery  = "INSERT INTO
                student(firstname, lastname, email, username, phone_number, pwd, roles, gender, class, subject, grade)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmts = $conn->prepare($sqlQuery);
            $stmts->execute([$firstname, $lastname, $email, 
                        $username, $phonenumber, $pass,
                        $roles, $gender, $classes, $subject,
                        $grade]);

            $sm = "New users created successfully";
            header("Location: ../students-add.php?success=$sm");
            exit;

       }
        
    } else {
        $em = "Invald gradeName Or gradeStatus";
        header("Location: ../students-add.php.php?error=$em");
        exit;
    }

?>