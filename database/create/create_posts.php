<?php

    include_once "./../Database.php";

    $sql = "CREATE TABLE Posts(
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            url TEXT NOT NULL,
            likes  INT NOT NULL,
            comment TEXT DEFAULT NULL,
            post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

