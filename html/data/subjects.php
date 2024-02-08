<?php

function getAllSubject($conn) {

    $sql = "SELECT * FROM subjects";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() >= 1) {
      $teachers = $stmt->fetchAll();
      return $teachers;
    }else {
        return 0;
    }
}

?>