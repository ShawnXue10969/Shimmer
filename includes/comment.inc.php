<?php
if (isset($_POST['submit-comment'])) {
    $uid = $_POST['uid'];
    $nid = $_POST['nid'];
    $date = $_POST['date'];
    $message = $_POST['message'];

    if (isset($_POST['anonymous']) || !isset($_POST['uid'])) {
        $uid = 0;
    }
    
    require_once 'dbh.inc.php';

    $sql = "INSERT INTO comments (nid, date, userId, message) VALUES ('$nid', '$date', '$uid', '$message');";
    $result = mysqli_query($conn, $sql);
    switch ($nid) {
        case 1:
            header('location: ../dk.php');
            break;
        case 2:
            header('location: ../dh.php');
            break;
        case 3:
            header('location: ../druid.php');
            break;
        case 4:
            header('location: ../mage.php');
            break;
        case 5:
            header('location: ../paladin.php');
            break;
    }
    
}
else {
    echo "Error";
}