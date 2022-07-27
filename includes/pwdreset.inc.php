<?php

if (isset($_POST["pwdreset-request"])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/web/infs3202/newpassword.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 36000;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $email = $_POST["email"];
    pwdReset($conn, $email, $selector, $token, $expires, $url);
    
}
else {
    header("location: ../index.php");
    exit();
}