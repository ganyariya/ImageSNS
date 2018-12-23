<?php
    include_once("database/Session.php");
    include_once("database/table/PostsTable.php");
    include_once("database/table/UsersTable.php");
    include_once("database/Database.php");

    $session = new Session();

    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    if (isset($_GET['user_id'])) {
        $page_id = $_GET['user_id'];
    }

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);
    $usersTable = new UsersTable($pdo);

    $posts = $postsTable->getAllPostByUserId($page_id);
    $user = $usersTable->getUserById($page_id);
?>
s
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>


<body>

    <?php include_once dirname(__FILE__) . "/header.php" ?>

    <main role="main">

        <strong>User: <?php echo $user->getUsername(); ?></strong>
        <div class="album py-5 bg-light" style="margin: 0 auto">
            <div class="container">
                <?php
                    foreach ($posts as $post) {
                        echo '<div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card mb-5 shadow-sm">
                        <img class="card-img-top"
                         src="images/' . $post->getUrl() . '"
                        alt="Card image cap">
                    <a class="user_link" href="mypage.php?user_id=' . $user->getId() . '">' . $user->getUsername() . '</a>
                        <div class="card-body">
                            <p class="card-text">' . $post->getComment() . '</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary"><i class="far fa-heart"></i> Like</button>';
                        if ($user_id === $user->getId())
                            echo '<button type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i> Edit</button>';
                        echo '</div>
                                <small class="text-muted">' . $post->getPostDate() . '</small>
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

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js"></script>
</body>
</html>

