<?php
    include_once "database/Session.php";
    include_once "database/table/PostsTable.php";
    include_once "database/table/UsersTable.php";
    include_once "database/Database.php";
    include_once "lib/util.php";


    $session = new Session();
    $title = "IMAGE SNS";

    //headerで使う
    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);
    $usersTable = new UsersTable($pdo);

    //ページネーションの設定
    $page = 1;
    $page_start = 0;
    if (isset($_GET['page']) && is_numeric($_GET['page'])) $page = (int)($_GET['page']);
    if ($page > 1) $page_start = ($page - 1) * 10;

    $posts = $postsTable->getLimitPostWithUser($page_start);
    $posts_all_number = $postsTable->getAllPostCount();
    $pagenation_number = (int)($posts_all_number / 10);
    if ($posts_all_number % 10) $pagenation_number++;

?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once "meta.php" ?>
</head>

<body>

    <?php include_once "header.php" ?>

    <main role="main">

        <?php if (!$session->is_login()) include_once "page_description.php"; ?>

        <div class="album py-6 bg-light" style="margin: auto;">
            <div class="container">

                <?php foreach ($posts as $post) : ?>
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
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    id="like<?php echo h($post->getId()); ?>">
                                                <i class="far fa-heart"> <?php echo h($post->getLikes()) ?></i>
                                            </button>

                                            <?php if ($user_id === $post->getUserId()) : ?>
                                                <button onclick="window.location.href='edit.php?id=<?php echo h($post->getId()); ?>'"
                                                        type="button" class="btn btn-sm btn-outline-secondary"><i
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
                <!--                スペースが上手くいかないので-->

                <div class="row justify-content-center" style="margin-bottom: 3rem">
                    <div class="col-md-6"></div>
                </div>

                <div class="row justify-content-center" style="margin-bottom: 2rem">
                    <div class="col-md-6">
                        <nav aria-label="ポストページネーション">
                            <ul class="pagination justify-content-center">
                                <?php if ($page != 1): ?>
                                    <li class="page-item"><a class="page-link"
                                                             href="index.php?page=<?php echo($page - 1); ?>">前へ</a></li>
                                <?php endif; ?>
                                <?php for ($i = 0; $i < $pagenation_number; $i++) : ?>
                                    <li class="page-item"><a class="page-link"
                                                             href="index.php?page=<?php echo($i + 1); ?>"><?php echo($i + 1); ?></a>
                                    </li>
                                <?php endfor; ?>
                                <?php if ($page != $pagenation_number): ?>
                                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo($page + 1); ?>">次へ</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <?php include_once "footer.php" ?>

    <script>
        iziToast.settings({
            icon: 'fontawesome'
        })
        <?php foreach($posts as $post) : ?>
        $('#like<?php echo h($post->getId());?>').click(function () {
            axios.get('like.php?id=<?php echo h($post->getId());?>')
                .then((response) => {
                    if (response.data == "success") {
                        var likes = $('#like<?php echo h($post->getId());?>').children().first();
                        likes.text(' ' + (parseInt(likes.text()) + 1));
                        iziToast.show({
                            theme: 'light',
                            title: 'I Love it!',
                            color: 'red',
                            titleColor: 'white',
                            icon: 'fa fa-heart',
                            iconColor: 'white'
                        })
                    }
                    if (response.data === 'not_login') {
                        iziToast.show({
                            theme: 'light',
                            title: 'Sorry',
                            titleColor: 'black',
                            icon: 'fa fa-times',
                            iconColor: 'black',
                            message: 'Please, login.'
                        })
                    }
                    if (response.data === 'no_id') {
                        iziToast.show({
                            theme: 'light',
                            title: 'Sorry',
                            titleColor: 'black',
                            icon: 'fa fa-times',
                            iconColor: 'black',
                            message: '????'
                        })
                    }
                })
        });
        <?php endforeach; ?>
    </script>

</body>
</html>
