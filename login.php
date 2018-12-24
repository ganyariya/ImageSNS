<?php
    include_once "database/Session.php";
    include_once "database/table/UsersTable.php";
    include_once "database/Database.php";
    include_once "lib/util.php";

    $isLoginSuccess = true;

    $session = New Session();
    $title  = "IMAGE SNS - LogIn";

    $db = new Database();
    $pdo = $db->pdo();

    $usersTable = new UsersTable($pdo);
    $username = null;

    if ($session->is_login()) {
        header('Location: index.php');
        exit();
    } else if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $user_id = $usersTable->isUserExists($username, $password);

        if ($user_id >= 0) {
            $session->login($username, $user_id, "./index.php");
        } else {
            $isLoginSuccess = false;
        }

    } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $_SESSION['csrf_token'] = $session->generate_token();
    }


?>
<!doctype html>
<html lang="jp">
<head>
    <?php include_once dirname(__FILE__) . "/meta.php" ?>
</head>

<body>

    <?php include_once dirname(__FILE__) . "/header.php" ?>

    <main role="main">
        <div class="signin">
            <form class="form-signin text-center" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Login</h1>
                <?php if (!$isLoginSuccess) echo "<label>usernameかパスワードが間違っています。</label>" ?>
                <label for="inputEmail" class="sr-only">Username</label>
                <input name="username" type="text" id="inputEmail" class="form-control" placeholder="User name"
                       value="<?php echo h($username);?>"
                       required
                       autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password"
                       required>
                <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            </form>
        </div>
    </main>

    <?php include_once dirname(__FILE__) . "/footer.php" ?>

</body>
</html>
