<?php
    include_once dirname(__FILE__) . "/database/Session.php";
    include_once dirname(__FILE__) . "/database/table/UsersTable.php";
    include_once dirname(__FILE__) . "/database/Database.php";
    include_once dirname(__FILE__) . "/lib/util.php";

    $isLoginSuccess = true;

    $session = New Session();
    $title  = "IMAGE SNS - SignUp";

    $db = new Database();
    $pdo = $db->pdo();

    $usersTable = new UsersTable($pdo);
    $same_user_name = false;

    if ($session->is_login() === true) {
        header('Location: ../../index.php');
    } else {
        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $re_password = $_POST['repassword'];
            $mail = $_POST["mail"];

            $password_check = $password === $re_password;

            $user = new User(0, $username, $password, $mail, 2, "", "");

            if ($usersTable->validate($user) && $password_check) {
                $id = $usersTable->add($user);
                $session->login($username, $id, "./index.php");
            }
            if (!$usersTable->validate($user)) $same_user_name = true;

        } else {
            $_SESSION['csrf_token'] = $session->generate_token();
        }
    }
?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body class="bg-light">
    <?php include_once("header.php") ?>

    <div class="container" style="margin-top: 2rem;">
        <div class="text-center">
            <h2>会員登録</h2>
        </div>
        <div class="col-md-8 order-md-1 signup" style="margin: 0 auto;">
            <form class="needs-validation" method="post">
                <div class="mb-3">
                    <label for="username">ユーザネーム</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input name="username" type="text" class="form-control" id="username" placeholder="ユーザネーム"
                               value="<?php if (isset($username)) echo(h($username)); ?>" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            ユーザネームを入力してください。
                        </div>
                    </div>
                    <?php if ($same_user_name): ?>
                        <div>
                            そのアカウントは使用されています。
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input name="mail" type="email" class="form-control" id="email" placeholder="you@example.com"
                           value="<?php if (isset($mail)) echo(h($mail)); ?>" required>
                    <div class="invalid-feedback">
                        正しいメールアドレスを入力してください。
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password">パスワード</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="**********"
                           required>
                    <div class="invalid-feedback">
                        パスワードを入力してください。
                    </div>
                </div>

                <div class="mb-3">
                    <label for="repassword">パスワード（確認）</label>
                    <input name="repassword" type="password" class="form-control" id="repassword"
                           placeholder="**********"
                           required>

                    <?php if (isset($password_check) && !$password_check): ?>
                        <div>
                            確認パスワードには同じパスワードを入力してください。
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="mb-4">
                <button name="submit" class="btn btn-primary btn-lg btn-block" type="submit">
                    Sign Up
                </button>
            </form>
        </div>
    </div>
    <?php include_once dirname(__FILE__) . "/footer.php" ?>

</body>
</html>