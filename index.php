<?php
    include_once dirname(__FILE__) . "/database/Session.php";
    include_once dirname(__FILE__) . "/database/table/PostsTable.php";
    include_once dirname(__FILE__) . "/database/table/UsersTable.php";
    include_once dirname(__FILE__) . "/database/Database.php";
    include_once dirname(__FILE__) . "/lib/util.php";

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

        <div class="album py-6 bg-light" style="margin: auto;">
            <div class="container">

                <?php foreach ($posts as $post) : ?>
                    <?php $user = $usersTable->getUserById($post->getUserId()); ?>
                    <div class="row justify-content-center" style="">
                        <div class="col-md-6">
                            <div style="margin-top: 4rem;"></div>
                            <div class="card mb-7 shadow-sm">
                                <img class="card-img-top"
                                     src="<?php echo 'images/' . h($post->getUrl()); ?>">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="<?php echo 'mypage.php?user_id=' . h($user->getId()); ?>" style="color: black"> <?php echo h($user->getUsername()); ?></a>
                                    </h5>
                                    <p class="card-text"> <?php echo h($post->getComment()) ?></p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    id="like<?php echo h($post->getId()); ?>">
                                                <i class="far fa-heart"> <?php echo h($post->getLikes()) ?></i>
                                            </button>

                                            <?php if ($user_id === $user->getId()) : ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                ><i class="fas fa-pen"></i> Edit
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
