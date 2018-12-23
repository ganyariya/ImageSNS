<?php
    include_once "database/Session.php";
    include_once "database/table/UsersTable.php";
    include_once "database/Database.php";
    include_once "lib/util.php";

    $isLoginSuccess = true;

    $session = New Session();

    $db = new Database();
    $pdo = $db->pdo();

    $usersTable = new UsersTable($pdo);

    if ($session->is_login()) {
        header('Location: ./index.php');
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
                <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>
                <?php if (!$isLoginSuccess) echo "<label>Username/Password違い</label>" ?>
                <label for="inputEmail" class="sr-only">Username</label>
                <input name="username" type="text" id="inputEmail" class="form-control" placeholder="User name"
                       required
                       autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password"
                       required>
                <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
        </div>
    </main>

    <?php include_once dirname(__FILE__) . "/footer.php" ?>

    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/popper.min.js"></script>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js"></script>
</body>
</html>
