<?php
include_once("database/Session.php");
include_once("database/table/PostsTable.php");
include_once("database/table/UsersTable.php");
include_once("database/Database.php");

$session = new Session();

$is_login = $session->is_login();
$user_id = $session->get_user_id();
$username = $session->get_user_name();

$db = new Database();
$pdo = $db->pdo();

$postsTable = new PostsTable($pdo);
$usersTable = new UsersTable($pdo);

$posts = $postsTable->getAllPost();
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
          integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Album example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
</head>

<body>

<?php include_once("header.php") ?>

<main role="main">
    <?php
    if (!$session->is_login()) {
        include_once("page_description.php");
    }

    echo '<div class="album py-5 bg-light" style="margin: 0 auto">
        <div class="container">';
    foreach ($posts as $post) {
        $user = $usersTable->getUserById($post->getUserId());

        echo '<div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card mb-5 shadow-sm">
                        <img class="card-img-top"
                         src="images/' . $post->getUrl() . '"
                        alt="Card image cap">
                    <a class="user_link" href="mypage.php?user_id=' . $user->getId() . '">' . $user->getUsername() . '</a>
                        <div class="card-body">
                            <p class="card-text">'.$post->getComment().'</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"><i class="far fa-heart"></i> Like</button>';
        if ($user_id === $user->getId())
                                    echo '<button type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i> Edit</button>';
                                echo '</div>
                                <small class="text-muted">9 mins</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
    }
    ?>
    </div>
    </div>

</main>

<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting
                started guide</a>.</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="../../assets/js/vendor/holder.min.js"></script>
</body>
</html>
