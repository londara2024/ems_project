<?php

    $class_name     = $_POST['class_name'];
    $class_status   = $_POST['class_status'];
    echo "$class_name , $class_status";

    if ($class_name && is_numeric($class_status)) {

        include "../connection/connection_db.php";

        // check if the user already exists
        $sql_check = "SELECT * FROM classes WHERE class_name = ? AND status = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$class_name, $class_status]);

        if ($stmt_check->rowCount() > 0) {
            $em  = "The class already exists";
            header("Location: ../classes.php?error=$em");
            exit;
         }else {
           $sql  = "INSERT INTO classes(class_name, status) VALUES(?, ?)";
           $stmt = $conn->prepare($sql);
           $stmt->execute([$class_name, $class_status]);
           $sm = "New class created successfully";
           header("Location: ../classes.php?error=$sm");
           exit;
         }

    } else {
        $em = "Invald ClassName Or ClassStatus";
        header("Location: ../classes.php?error=$em");
	    exit;
    }

?>