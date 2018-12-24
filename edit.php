<?php
    include_once dirname(__FILE__) . "/database/Session.php";
    include_once dirname(__FILE__) . "/database/table/PostsTable.php";
    include_once dirname(__FILE__) . "/database/table/UsersTable.php";
    include_once dirname(__FILE__) . "/database/Database.php";
    include_once dirname(__FILE__) . "/lib/util.php";

    $session = new Session();
    $title = "IMAGE SNS - edit";

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

    $post->username = $username;

?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body>

    <?php include_once dirname(__FILE__) . "/header.php" ?>

    <main role="main">

        <?php if (!$session->is_login()) include_once dirname(__FILE__) . "/page_description.php"; ?>

        <div class="album py-6 bg-light" style="margin: auto;">
            <div class="container">
                <div class="row justify-content-center" style="">
                    <div class="col-md-6">
                        <div style="margin-top: 4rem;"></div>
                        <div class="card mb-7 shadow-sm">
                            <img class="card-img-top"
                                 src="<?php echo 'images/' . h($post->getUrl()); ?>">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="<?php echo 'mypage.php?user_id=' . h($post->getUserId()); ?>"
                                       style="color: black"> <?php echo h($post->username); ?></a>
                                </h5>
                                <p class="card-text"> <?php echo h($post->getComment()) ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><?php echo h($post->getPostDate()); ?></small>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 3rem; margin-bottom: 3rem; text-align: center;">
                            <button name="submit" class="btn btn-danger btn-lg" type="submit" onclick="window.location.href='delete.php?id=<?php echo h($post->getId());?>'">
                                <i class="fa fa-times"></i> Delete
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>

    <?php include_once dirname(__FILE__) . "/footer.php" ?>


</body>
</html>