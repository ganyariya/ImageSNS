<?php
include_once dirname(__FILE__) . "/database/Session.php";
include_once dirname(__FILE__) . "/database/table/UsersTable.php";
include_once dirname(__FILE__) . "/database/Database.php";
include_once dirname(__FILE__) . "/lib/util.php";

$session = New Session();
$title = "IMAGE SNS - Change Password";

//headerで使う
$is_login = $session->is_login();
$user_id = $session->get_user_id();
$username = $session->get_user_name();

$db = new Database();
$pdo = $db->pdo();

$usersTable = new UsersTable($pdo);
$isOldPasswordMatch = false;
$isSubmit = false;

if (!$session->is_login()) {
    header('Location: ../../login.php');
} else {
    if (isset($_POST['submit'])) {
        $isSubmit = true;
        $oldPassword = $_POST['oldpassword'];
        $newPassword = $_POST['newpassword'];
        $reNewPassword = $_POST['renewpassword'];

        $password_check = $newPassword === $reNewPassword;

        $user_id = $session->get_user_id();
        $isOldPasswordMatch = $usersTable->isPasswordMatch($user_id, $oldPassword);

        if ($isOldPasswordMatch && $password_check) {
            $usersTable->changePassword($user_id, $newPassword);

            header('Location: ../../index.php');
        }
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
        <h2>パスワード更新</h2>
    </div>
    <div class="col-md-8 order-md-1 signup" style="margin: 0 auto;">
        <form class="needs-validation" method="post">
            <div class="mb-3">
                <label for="username">旧パスワード</label>
                <div class="input-group">
                    <input name="oldpassword" type="password" class="form-control" id="username" placeholder="旧パスワード"
                           required>
                    <div class="invalid-feedback" style="width: 100%;">
                        旧パスワードを入力してください。
                    </div>
                </div>
                <?php if (!$isOldPasswordMatch && $isSubmit): ?>
                    <div>
                        正しいパスワードを入力してください。
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password">新パスワード</label>
                <input name="newpassword" type="password" class="form-control" id="password" placeholder="**********"
                       required>
                <div class="invalid-feedback">
                    パスワードを入力してください。
                </div>
            </div>

            <div class="mb-3">
                <label for="repassword">新パスワード（確認）</label>
                <input name="renewpassword" type="password" class="form-control" id="repassword"
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
                更新
            </button>
        </form>
    </div>
</div>
<?php include_once dirname(__FILE__) . "/footer.php" ?>

</body>
</html>