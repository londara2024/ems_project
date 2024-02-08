<?php

    $grade_name     = $_POST['grade_name'];
    $grade_status   = $_POST['grade_status'];
    $grade_id       = $_POST['grade_id'];
    echo "$grade_name , $grade_status, $grade_id";

    if ($grade_name && is_numeric($grade_status)) {

        include "../connection/connection_db.php";

        // check if the user already exists
        $sql_check = "SELECT * FROM grades WHERE grade_name = ? AND status = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$grade_name, $grade_status]);

        if ($stmt_check->rowCount() > 0) {
            $em  = "The grade already exists";
            header("Location: ../grades.php?error=$em");
            exit;
         }else {
            if ($grade_id != '' || $grade_id != null) {

                $sql  = "UPDATE grades SET grade_name=?, status=?
                         WHERE grade_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$grade_name, $grade_status, $grade_id]);
                $sm = "grades updated successfully";

            } else {
                $sql  = "INSERT INTO grades(grade_name, status) VALUES(?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$grade_name, $grade_status]);
                $sm = "New grade created successfully";
            }
          
           header("Location: ../grades.php?error=$sm");
           exit;
         }

    } else {
        $em = "Invald gradeName Or gradeStatus";
        header("Location: ../grades.php?error=$em");
	    exit;
    }

?>