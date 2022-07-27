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
    <link href="css/login.css" rel="stylesheet">
    <link href="css/sidebar.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/pwdindicator.css" rel="stylesheet">
    <script>const whTooltips = {colorLinks: true, iconizeLinks: true, renameLinks: true};</script>
    <script src="https://wow.zamimg.com/widgets/power.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        } else {
            header('location: login.php');
            exit();
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






<div class="main">
    <h2>Profile</h2>
    <div class="p-img-wrap">
    <?php
    require_once 'includes/dbh.inc.php';
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
        $sql = "SELECT * FROM profiles WHERE userId = $id";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='profile-img-wrap'>";
                echo "<img class='profile-img' src='src/profile/".$id.".".$row['type']."'>";
                echo "</div>";
            }
        } else {echo "no profile img yet";}
    }
    ?>

    <form id="drop-form" action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
        <div class="drag-area">
            <div class="icon"><i class="fas fa-cloud-upload-alt"></i></div>
            <img id="preview" src="#" alt="your image">
            <a class="load-btn">Browse File</a>
            <input class="file-input" accept="image/*" type="file" name="file" hidden>
            <input id="uid" type="hidden" name="uid" value="<?php echo $id; ?>">
            <button type="button" class="btn-close btn-close-white" aria-label="Close"></button>
        </div>
        <button class="submit-btn btn btn-primary" type="submit" name="profile_submit">Upload</button>
    </form>
    </div>



    <div class="profile-wrap col-xl-4 col-lg-6 col-md-8 col-sm-10">
        <div id="alert-wrap-name">

        </div>
        <form novalidate id="form-name" class="needs-validation" action="includes/profile.inc.php" method="POST">
        <div class="form-floating mt-3 input-wrap">
            <input id="uid2" type="hidden" name="uid" value="<?php echo $id; ?>">
            <input id="name" type="text" class="form-control" name="name" placeholder=" " required>
            <label id="name-lable" for="name">
                <?php
                $sql = "SELECT * FROM users WHERE userId = $id";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $uName = $row['userFullName'];
                        echo "Full name: ".$uName;
                    }
                }
                ?>
            </label>
        </div>
        <button id="submit-name" type="submit" name="change_name" class="p-btn mt-3 btn btn-primary">Change name</button>
        </form>

        <form novalidate id="form-pwd" class="needs-validation" action="includes/profile.inc.php" method="POST">
        <div id="alert-wrap-pwd">
                    
        </div>
        <input id="uid3" type="hidden" name="uid" value="<?php echo $id; ?>">
        <div class="form-floating mt-3 input-wrap">
            <input id="pwd" class="form-control" onkeyup="trigger()" type="password" name="pwd" placeholder=" " required>
            <label for="pwd">New Password</label>
        </div>
        <div class="form-floating mt-3 indicator">
            <span class="weak"></span>
            <span class="medium"></span>
            <span class="strong"></span>
        </div>
        <div class="form-floating mt-3 input-wrap">
            <input id="pwdcf" type="password" class="form-control" name="pwdcf" placeholder=" " required>
            <label for="pwdcf">Confirm Password</label>
        </div>
        <button id="change-pwd" type="submit" name="change_pwd" class="p-btn mt-3 btn btn-primary">Change password</button>
        </form>
    </div>
</div>



<script>
    $(document).ready(function() {
        <?php
            $pName = basename(__FILE__, ".php");
        ?>
        const pName = '<?php echo $pName ?>';
        switch(pName) {
            case 'index':
                document.querySelector("#l_home").classList.add("active");
                break;
            case 'leaderboard':
                document.querySelector("#l_leaderboard").classList.add("active");
                break;
            case 'profile':
                document.querySelector("#l_profile").classList.add("active");
                document.querySelector("#user-collapse").classList.add("show");
                document.querySelector("#user-toggle").setAttribute("aria-expanded", "true");
                break;
            case 'pinned':
                document.querySelector("#l_pinned").classList.add("active");
                document.querySelector("#user-collapse").classList.add("show");
                document.querySelector("#user-toggle").setAttribute("aria-expanded", "true");
                break;
        }

        $("#form-name").submit(function(event) {
            event.preventDefault();
            event.stopPropagation();
            var name = $("#name").val();
            var uid = $("#uid2").val();
            var submit = $("#submit-name").val();
            $("#alert-wrap-name").load("includes/profile.inc.php", {
                name: name,
                uid: uid,
                change_name: submit
            });
        });

        $("#form-pwd").submit(function(event) {
            event.preventDefault();
            event.stopPropagation();
            var pwd = $("#pwd").val();
            var pwdcf = $("#pwdcf").val();
            var uid = $("#uid3").val();
            var submit = $("#change-pwd").val();
            $("#alert-wrap-pwd").load("includes/profile.inc.php", {
                pwd: pwd,
                pwdcf: pwdcf,
                uid: uid,
                change_pwd: submit
            });
        });
        
    });

    

    const indicator = document.querySelector(".indicator");
      const input = document.querySelector("#pwd");
      const weak = document.querySelector(".weak");
      const medium = document.querySelector(".medium");
      const strong = document.querySelector(".strong");
      let regExpWeak = /[a-z]/;
      let regExpMedium = /\d+/;
      let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;
      function trigger(){
        if(input.value != ""){
          indicator.style.display = "block";
          indicator.style.display = "flex";
          if(input.value.length <= 3 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong)))no=1;
          if(input.value.length >= 6 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong))))no=2;
          if(input.value.length >= 6 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong))no=3;
          if(no==1){
            weak.classList.add("active");
            //text.style.display = "block";
            //text.textContent = "Your password is too week";
            //text.classList.add("weak");
          }
          if(no==2){
            medium.classList.add("active");
            //text.textContent = "Your password is medium";
            //text.classList.add("medium");
          }else{
            medium.classList.remove("active");
            //text.classList.remove("medium");
          }
          if(no==3){
            weak.classList.add("active");
            medium.classList.add("active");
            strong.classList.add("active");
            //text.textContent = "Your password is strong";
            //text.classList.add("strong");
          }else{
            strong.classList.remove("active");
            //text.classList.remove("strong");
          }
        }else{
          indicator.style.display = "none";
          //text.style.display = "none";
        }
      }
</script>
<script src="js/dragdrop.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
<?php include_once 'footer.php'; ?>