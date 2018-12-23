<?php
include_once "database/Session.php";

$session=new Session();

$session->logout();

header('Location: ../../');
