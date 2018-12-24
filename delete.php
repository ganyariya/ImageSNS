<?php
    include_once "database/Session.php";
    include_once "database/table/PostsTable.php";
    include_once "database/table/UsersTable.php";
    include_once "database/Database.php";
    include_once "lib/util.php";

    $session = new Session();

    //headerで使う
    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);
    $usersTable = new UsersTable($pdo);

    if (!$is_login || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: index.php');
        exit();
    }

    $post_id = $_GET['id'];

    $post = $postsTable->getPostById($post_id);
    if ((!is_object($post) && $post == -1) || $post->getUserId() != $user_id) {
        header('Location: index.php');
        exit();
    }

    $postsTable->delete($post_id);
    header('Location: index.php');
