<?php
include_once "database/Session.php";
include_once "database/table/UsersTable.php";
include_once "database/Database.php";

$isLoginSuccess=true;

$session =New Session();

$db = new Database();
$pdo = $db->pdo();

$usersTable=new UsersTable($pdo);

if ($session->is_login()) {
    header('Location: ../../');
} else if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["submit"])) {
    $username=$_POST["username"];
    $password=$_POST["password"];

    $user_id=$usersTable->isUserExists($username,$password);

    if ($user_id>=0){
        $session->login($username,strval($user_id),"../../");
    }else{
        $isLoginSuccess=false;
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

    <title>Album example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/cover.css" rel="stylesheet">
    <link href="/css/signin.css" rel="stylesheet">
</head>

<body>

<header>
    <div class="navbar navbar-dark bg-dark shadow-sm">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                    <circle cx="12" cy="13" r="4"></circle>
                </svg>
                <strong>IMAGE SNS</strong>
            </a>
        </div>
    </div>
</header>

<main role="main">
    <div class="signin">
        <form class="form-signin text-center" method="post">
            <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>
            <?php if ($isLoginSuccess===false) echo"<label>Username/Password違い</label>" ?>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input name="username" type="text" id="inputEmail" class="form-control" placeholder="Email address" required
                   autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password"
                   required>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        </form>
    </div>
</main>

<footer class="text-muted">
    <div class="container">
        <p class="float-right">
            <a href="#">Back to top</a>
        </p>
        <p>Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
        <p>New to Bootstrap? <a href="../../">Visit the homepage</a> or read our <a href="../../getting-started/">getting
                started guide</a>.</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="../../assets/js/vendor/holder.min.js"></script>
</body>
</html>
