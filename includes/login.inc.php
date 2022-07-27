<?php

if (isset($_POST["submit"])) {

    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $remember = false;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (!empty($_POST["remember"])) {
        $remember = true;
    }

    loginUser($conn, $username, $pwd, $remember);
}
else {
    header("location: ../login.php");
    exit();
}