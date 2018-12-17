<?php

    include_once "./Database.php";

    $sql = "CREATE TABLE Users(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password TEXT NOT NULL,
            mail TEXT NOT NULL,
            user_type INT NOT NULL,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
    )";

    try {
        $db = new Database();
        $pdo = $db->pdo();
        $pdo->query($sql);
    } catch (PDOException $e) {
        echo $e;
        exit();
    }

