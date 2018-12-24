<?php
    include_once "database/Session.php";
    include_once "database/table/PostsTable.php";
    include_once "database/table/UsersTable.php";
    include_once "database/Database.php";
    include_once "lib/util.php";


    $session = new Session();

    //headerで使う
    $is_login = $session->is_login();
    if (!$is_login) {
        echo "not_login";
        exit;
    }
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "no_id";
        exit;
    }


    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);
    $id = $_GET['id'];

    if ($postsTable->incrementLike($id) === 1) echo "success";
    else echo "db_error";
