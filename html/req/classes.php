<?php

    $class_name     = $_POST['class_name'];
    $class_status   = $_POST['class_status'];
    $class_id       = $_POST['class_id'];

    echo "$class_name , $class_status, $class_id";

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
        
            if ($class_id != '' || $class_id != null) { // update Data

                $sql  = "UPDATE classes SET class_name=?, status=?
                         WHERE class_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$class_name, $class_status, $class_id]);
                $sm = "Class updated successfully";

            } else { // Insert New Data

                $sql  = "INSERT INTO classes(class_name, status) VALUES(?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$class_name, $class_status]);
                $sm = "New class created successfully";
                
            }

            header("Location: ../classes.php?error=$sm");
            exit;
         }

    } else {
        $em = "Invald ClassName Or ClassStatus";
        header("Location: ../classes.php?error=$em");
	    exit;
    }

?>