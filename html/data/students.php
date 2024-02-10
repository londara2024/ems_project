<?php

function getAllStudent($conn) {

    $sql = "SELECT * FROM student";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() >= 1) {
      $teachers = $stmt->fetchAll();
      return $teachers;
    }else {
        return 0;
    }
}

function searchStudents($class, $subject, $grade, $conn){
  $sql = "SELECT * FROM student 
          WHERE class = ? 
          OR subject = ? 
          OR grade = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$class, $subject, $grade]);
  if ($stmt->rowCount() == 1) {
    $students = $stmt->fetchAll();
    return $students;
  }else {
   return 0;
  }
}

?>