<?php
$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "1934769dea6bfb76";
$dbName = "shimmer";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}