<?php
include_once "database/Session.php";
include_once "database/table/UsersTable.php";
include_once "database/table/PostsTable.php";
include_once "database/entity/Post.php";
include_once "database/Database.php";

$isLoginSuccess = true;

$session = New Session();

$is_login = $session->is_login();
$user_id = $session->get_user_id();
$username = $session->get_user_name();

$db = new Database();
$pdo = $db->pdo();

$usersTable = new UsersTable($pdo);
$postsTable=new PostsTable($pdo);

if ($session->is_login() === false) {
    header('Location: ../../login.php');
} else {
    if (isset($_POST['btnUpload'])) {
        $filename = $session->get_user_id() . date('dmYHis') . $_FILES['image']['name'];
        $comment = $_POST['comment'];
        move_uploaded_file($_FILES['image']['tmp_name'], './images/' . $filename);

        $post = new Post(0, $session->get_user_id(), $filename, 0, $comment, "", "", "");
        $postsTable->add($post);
        header('Location: ../../index.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Checkout example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
    <link href="/css/form-validation.css" rel="stylesheet">
</head>

<body class="bg-light">
<?php include_once("header.php") ?>
<div class="container">
    <div class="text-center">
        <img class="d-block mx-auto mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
        <h2>Checkout form</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group
            has a validation state that can be triggered by attempting to submit the form without completing it.</p>
    </div>
    <div class="col-md-8 order-md-1 signup">
        <form class="needs-validation" novalidate method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="FILE">FILE</label>
                <div class="input-group">
                    <input name="image" type="file" class="form-control" id="username" placeholder="file URL" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        ユーザネームを入力してください。
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email">Comment <span class="text-muted">(Optional)</span></label>
                <textarea name="comment" type="text" class="form-control" placeholder="you@example.com"></textarea>
                <div class="invalid-feedback">
                    正しいメールアドレスを入力してください。
                </div>
            </div>

            <hr class="mb-4">
            <button name="btnUpload" class="btn btn-primary btn-lg btn-block" type="submit">Upload</button>
        </form>
    </div>
</div>

<?php include("footer.php") ?>
</div>


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
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';

        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
</body>
</html>
