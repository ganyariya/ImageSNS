<?php

class Database
{
    private $host = "localhost";
    private $dbname = "ubimap_team08db";
    private $username = "root";
    private $password = "vertrigo";

    public function pdo()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //接続されたpdoを返す
        return $pdo;
    }
}
