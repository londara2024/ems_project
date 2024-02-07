<?php

    $localhost  = "localhost";
    $db_name    = "ems_db";
    $uesrname   = "root";
    $password   = "";

    try {
        $conn = new PDO("mysql:host=$localhost;dbname=$db_name", $uesrname, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOExeption $e){
        echo "Connection failed: ". $e->getMessage();
        exit;
    }

?>