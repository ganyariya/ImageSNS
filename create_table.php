<?php
/**
 * Created by PhpStorm.
 * User: megas
 * Date: 2018/12/20
 * Time: 16:29
 */

$sql = "CREATE TABLE User(
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password TEXT NOT NULL,
        add_date TIMESTAMP,
        mail TEXT NOT NULL,
        type INT NOT NULL
)";

runQuery($sql);