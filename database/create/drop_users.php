<?php

    include_once "./../Database.php";

    $sql = "DROP TABLE Users";

    try {
        $db = new Database();
        $pdo = $db->pdo();
        $pdo->query($sql);
    } catch (PDOException $e) {
        echo $e;
        exit();
    }

