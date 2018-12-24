<?php
    include_once dirname(__FILE__) . "/database/Session.php";
    include_once dirname(__FILE__) . "/database/table/PostsTable.php";
    include_once dirname(__FILE__) . "/database/table/UsersTable.php";
    include_once dirname(__FILE__) . "/database/Database.php";
    include_once dirname(__FILE__) . "/lib/util.php";

    $session = new Session();

    //headerで使う
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
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body>

    <?php include_once dirname(__FILE__) . "/header.php" ?>

    <main role="main">

        <?php if (!$session->is_login()) include_once dirname(__FILE__) . "/page_description.php"; ?>

        <div class="album py-5 bg-light" style="margin: 0 auto">
            <div class="container">

                <?php foreach ($posts as $post) : ?>
                    <?php $user = $usersTable->getUserById($post->getUserId()); ?>
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <div class="card mb-5 shadow-sm">
                                <img class="card-img-top"
                                     src="<?php echo 'images/' . h($post->getUrl()); ?>"
                                     alt="Card image cap">
                                <a class="user_link"
                                   href="<?php echo 'mypage.php?user_id=' . h($user->getId()); ?>"> <?php echo h($user->getUsername()); ?></a>
                                <div class="card-body">
                                    <p class="card-text"> <?php echo h($post->getComment()) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"><i
                                                        class="far fa-heart"></i> Like
                                            </button>

                                            <?php if ($user_id === $user->getId()) : ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"><i
                                                            class="fas fa-pen"></i> Edit
                                                </button>
                                            <?php endif ?>
                                        </div>
                                        <small class="text-muted"><?php echo h($post->getPostDate()); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

                <!--                --><?php
                    //                    foreach ($posts as $post) {
                    //                        $user = $usersTable->getUserById($post->getUserId());
                    //
                    //                        echo '<div class="row justify-content-center">
                    //                <div class="col-md-5">
                    //                    <div class="card mb-5 shadow-sm">
                    //                        <img class="card-img-top"
                    //                         src="images/' . $post->getUrl() . '"
                    //                        alt="Card image cap">
                    //                    <a class="user_link" href="mypage.php?user_id=' . $user->getId() . '">' . $user->getUsername() . '</a>
                    //                        <div class="card-body">
                    //                            <p class="card-text">' . $post->getComment() . '</p>
                    //                            <div class="d-flex justify-content-between align-items-center">
                    //                                <div class="btn-group">
                    //                                    <button type="button" class="btn btn-sm btn-outline-secondary"><i class="far fa-heart"></i> Like</button>';
                    //                        if ($user_id === $user->getId())
                    //                            echo '<button type="button" class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i> Edit</button>';
                    //                        echo '</div>
                    //                                <small class="text-muted">' . $post->getPostDate() . '</small>
                    //                            </div>
                    //                        </div>
                    //                    </div>
                    //                </div>
                    //            </div>';
                    //                    }
                    //                ?>
            </div>
        </div>

    </main>


    <?php include_once dirname(__FILE__) . "/footer.php" ?>

</body>
</html>
