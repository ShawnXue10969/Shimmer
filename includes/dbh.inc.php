<?php
$serverName = "heroku_6baf9113ea8ab8d";
$dbUsername = "be03ba24e8d9a2";
$dbPassword = "38b94132";
$dbName = "shimmer-heroku";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}