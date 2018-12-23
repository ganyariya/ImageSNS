<?php
/**
 * Created by PhpStorm.
 * User: megas
 * Date: 2018/12/20
 * Time: 17:27
 */

include_once "database/Database.php";
include_once "database/entity/User.php";
include_once "database/table/UsersTable.php";



$db = new Database();
$pdo = $db->pdo();


$user=new User(0,"admin","admin","admin@gmail.com",1,"","");
$usersTable=new UsersTable($pdo);
$usersTable->add($user);