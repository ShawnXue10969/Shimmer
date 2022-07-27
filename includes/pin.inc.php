<?php
if (isset($_POST['toggle'])) {
    $uid = $_POST['uid'];
    $nid = $_POST['nid'];
    
    require_once 'dbh.inc.php';

    $sql = "SELECT * FROM pins WHERE userId = '$uid' AND nid = '$nid';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $sql = "DELETE FROM pins WHERE userId = '$uid' AND nid = '$nid';";
        $result = mysqli_query($conn, $sql);
        echo "<i class='far fa-star'></i>";
    } else {
        $sql = "INSERT INTO pins (userId, nid) VALUES ('$uid', '$nid');";
        $result = mysqli_query($conn, $sql);
        echo "<i class='fas fa-star'></i>";
    }
} else {
    header("Location: index.php");
}