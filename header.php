<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/sidebar.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>const whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
    <script src="https://wow.zamimg.com/widgets/power.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Shimmer</title>
</head>

<body>
    <div id="sidebar" class="d-flex flex-column p-3">
        <div class="d-flex mb-3 logo-wrap">
            <a class="d-flex" href="">
                <img class="logo" src="src/images/logo.svg">
                <span>Shimmer</span>
            </a>
        </div>
        <?php
        if (isset($_SESSION["useruid"])) {
            ?>
            <div class="nav-item mb-1">
                <a class="nav-link text-white d-flex" id="user-toggle" data-bs-toggle="collapse" data-bs-target="#user-collapse"
                    aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                    User
                </a>
                <div id="user-collapse" class="collapse">
                    <ul class="list-unstyled small nav-pills flex-column mb-auto">
                        <li>
                            <a id="l_profile" href="profile.php" class="nav-link text-white">
                                <i class="fas fa-address-card"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <a id="l_pinned" href="pinned.php" class="nav-link text-white">
                                <i class="fas fa-star"></i>
                                Pinned
                            </a>
                        </li>
                        <li>
                            <a href="includes/logout.inc.php" class="nav-link text-white">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
        }
        ?>

        <ul class="nav nav-pills flex-column mb-auto">
            <?php
            if (!isset($_SESSION["useruid"])) {
                echo '
                <li class="nav-item">
                    <a href="login.php" class="nav-link text-white">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                </li>
                ';
            }
            ?>
            
            <li class="nav-item">
                <a id="l_home" href="index.php" class="nav-link text-white">
                    <i class="fas fa-home"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a id="l_leaderboard" href="leaderboard.php" class="nav-link text-white">
                    <i class="fas fa-trophy"></i>
                    Leaderboard
                </a>
            </li>
        </ul>
    </div>