<?php
    include_once "database/Session.php";
    include_once "database/table/PostsTable.php";
    include_once "database/entity/Post.php";
    include_once "database/Database.php";

    $session = New Session();

    //headerで使う
    $is_login = $session->is_login();
    $user_id = $session->get_user_id();
    $username = $session->get_user_name();

    $db = new Database();
    $pdo = $db->pdo();

    $postsTable = new PostsTable($pdo);

    if ($session->is_login() === false) {
        header('Location: /login.php');
    } else {
        if (isset($_POST['btnUpload'])) {
            $filename = $session->get_user_id() . date('dmYHis') . $_FILES['image']['name'];
            $comment = $_POST['comment'];
            move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $filename);

            $post = new Post(0, $session->get_user_id(), $filename, 0, $comment, "", "", "");
            $postsTable->add($post);
            header('Location: /index.php');
        }
    }
?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body class="bg-light">
    <?php include_once dirname(__FILE__) . "/header.php" ?>
    <div class="container">
        <div class="text-center">
            <h2>Checkout form</h2>
        </div>
        <div class="col-md-8 order-md-1 signup" style="margin: 0 auto;">
            <form class="needs-validation"  method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="FILE">FILE</label>
                    <div class="input-group">
                        <input name="image" type="file" class="form-control" id="username" placeholder="file URL"
                               required>
                        <div class="invalid-feedback" style="width: 100%;">
                            画像を選択してください。
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Comment <span class="text-muted">(Optional)</span></label>
                    <textarea name="comment" type="text" class="form-control" placeholder="Comment"></textarea>
                </div>

                <hr class="mb-4">
                <button name="btnUpload" class="btn btn-primary btn-lg btn-block" type="submit">Upload</button>
            </form>
        </div>
    </div>

    <?php include_once dirname(__FILE__) . "/footer.php" ?>

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js"></script>
</body>
</html>
