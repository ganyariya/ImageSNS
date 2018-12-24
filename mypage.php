<?php
    include_once dirname(__FILE__) . "/database/Session.php";
    include_once dirname(__FILE__) . "/database/table/PostsTable.php";
    include_once dirname(__FILE__) . "/database/table/UsersTable.php";
    include_once dirname(__FILE__) . "/database/Database.php";
    include_once dirname(__FILE__) . "/lib/util.php";

    $session = new Session();
    $title = "IMAGE SNS - MyPage";

    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);
    $usersTable = new UsersTable($pdo);

    //GETパラメータがないなら
    if (!isset($_GET['user_id'])) {
        header('Location: index.php');
        exit;
    }

    $user_id_by_get = $_GET['user_id'];

    //もしGETのユーザーIDが正しくないなら
    if (!$usersTable->isUserExistsById($user_id_by_get)) {
        header('Location: index.php');
        exit;
    }

    $user = $usersTable->getUserById($user_id_by_get);
    $posts = $postsTable->getAllPostByUserIdWithUser($user_id_by_get);
?>

<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>


<body>

    <?php include_once dirname(__FILE__) . "/header.php" ?>

    <main role="main">


        <div class="album py-6 bg-light" style="margin: auto;">
            <div class="container">
                <div class="row justify-content-center" style="">
                    <div class="col-md-6">
                        <h3 style="margin-top:3rem;"><strong>User: <?php echo $user->getUsername(); ?></strong></h3>
                        <?php foreach ($posts as $post) : ?>
                            <div style="margin-top: 3rem;"></div>
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


                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>

    </main>


    <?php include_once dirname(__FILE__) . "/footer.php" ?>

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

