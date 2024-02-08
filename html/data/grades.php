<?php

function getAllGrades($conn) {

    $sql = "SELECT * FROM grades";

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