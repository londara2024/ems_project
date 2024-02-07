<?php

    $subject_name     = $_POST['subject_name'];
    $subject_status   = $_POST['subject_status'];
    echo "$subject_name , $subject_status";

    if ($subject_name && is_numeric($subject_status)) {

        include "../connection/connection_db.php";

        // check if the user already exists
        $sql_check = "SELECT * FROM subjects WHERE subject_name = ? AND status = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->execute([$subject_name, $subject_status]);

        if ($stmt_check->rowCount() > 0) {
            $em  = "The subject already exists";
            header("Location: ../subjects.php?error=$em");
            exit;
         }else {
           $sql  = "INSERT INTO subjects(subject_name, status) VALUES(?, ?)";
           $stmt = $conn->prepare($sql);
           $stmt->execute([$subject_name, $subject_status]);
           $sm = "New subject created successfully";
           header("Location: ../subjects.php?error=$sm");
           exit;
         }

    } else {
        $em = "Invald SubjectName Or SubjectStatus";
        header("Location: ../subjects.php?error=$em");
	    exit;
    }

?>