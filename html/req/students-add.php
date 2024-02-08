<?php

    $basic_fristname    = $_POST['basic-fristname'];
    $basic_lastname     = $_POST['basic-lastname'];
    $basic_username     = $_POST['basic-username'];
    $basic_password     = $_POST['basic-password'];
    $basic_email        = $_POST['basic-email'];
    $basic_phon         = $_POST['basic-phon'];
    $gerden_selected    = $_POST['gerden_selected'];
    $class_selected     = $_POST['class_selected'];
    $subject_selected   = $_POST['subject_selected'];
    $grade_selected     = $_POST['grade_selected'];


    echo "$basic_fristname, $basic_lastname, $basic_username, 
            $basic_password, $basic_email, $basic_phon, $gerden_selected, 
            $class_selected, $subject_selected, $grade_selected";



    if ($basic_fristname && $basic_lastname && $basic_username && 
        $basic_password && $basic_email && $basic_phon && $gerden_selected && 
        $class_selected && $subject_selected && $grade_selected) {

        include "../connection/connection_db.php";
        
       // encode password
       $password = password_hash($basic_password, PASSWORD_DEFAULT);
       $roles = "Student";

       // check if the user already exists
       $sql_check = "SELECT * FROM users WHERE username = ? AND pwd = ? AND email = ?";
       $stmt_check = $conn->prepare($sql_check);
       $stmt_check->execute([$username, $password, $email]);

       if ($stmt_check->rowCount() > 0) {
          $em  = "The users already exists";
          header("Location: ../students-add.php?error=$em");
          exit;
       }else {

         $sql  = "INSERT INTO
                users(firstname, lastname, email, username, phone_number, pwd, roles, gender)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare($sql);
         $stmt->execute([$basic_fristname, $basic_lastname, $basic_email, 
                        $basic_username, $basic_phon, $password, 
                        $roles, $gerden_selected]);
        

         // insert into student
         $sql  = "INSERT INTO
                student(firstname, lastname, email, username, phone_number, pwd, roles, gender, class, subject, grade)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
         $stmt = $conn->prepare($sql);
         $stmt->execute([$basic_fristname, $basic_lastname, $basic_email, 
                        $basic_username, $basic_phon, $password,
                        $roles, $gerden_selected, $class_selected, $subject_selected,
                        $grade_selected]);

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