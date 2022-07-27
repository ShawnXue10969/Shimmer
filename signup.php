<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="fontawesome-free-5.15.3-web/css/all.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
    <link href="css/pwdindicator.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <section class="form-wrap">
            <div class="d-flex mb-3 justify-content-center">
                <a href="index.php">
                    <img class="logo" src="src/images/logo.svg">
                </a>
            </div>
            <form novalidate class="needs-validation login-form" action="includes/signup.inc.php" method="POST">
                <div id="alert-wrap">
                    
                </div>
            <?php
            
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Please fill in all fields!
                    </div>
                    ";
                }
                else if ($_GET["error"] == "invaliduid") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Please choose a proper username!
                    </div>
                    ";
                }
                else if ($_GET["error"] == "invalidemail") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Please choose a proper email!
                    </div>
                    ";
                }
                else if ($_GET["error"] == "pwdmismatch") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Passwords don't match!
                    </div>
                    ";
                }
                else if ($_GET["error"] == "stmtfailed") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Something went wrong, please try again.
                    </div>
                    ";
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                        Username already taken!
                    </div>
                    ";
                }
                else if ($_GET["error"] == "none") {
                    echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        Signup successful!
                        <a href='login.php' class='alert-link'>Log in</a>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                    ";
                }
            }
            

            ?>
            
                <div class="form-floating mt-3 input-wrap">
                    <input id="name" type="text" class="form-control" name="name" placeholder=" " required>
                    <label for="name">Full name</label>
                </div>
                
                <div class="form-floating mt-3 input-wrap">
                    <input id="email" type="email" class="form-control" name="email" placeholder=" " required>
                    <label for="email">Email</label>
                </div>
                <div class="form-floating mt-3 input-wrap">
                    <input id="uid" type="text" class="form-control" name="uid" placeholder=" " required>
                    <label for="uid">Username</label>
                </div>
                <div class="form-floating mt-3 input-wrap">
                    <input id="pwd" class="form-control" onkeyup="trigger()" id="pwd" type="password" name="pwd" placeholder=" " required>
                    <label for="pwd">Password</label>
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
                <button id="submit" type="submit" name="submit" class="mt-3 btn btn-primary blue">Signup</button>
                <div class="text-center mt-2">
                    <span>
                        Already have an account?
                        <a href="login.php">Log in</a>
                    </span>
                </div>
            </form>
        </section>
    </div>

    <script>
        /* code comes from  https://www.codingnepalweb.com/2020/07/password-strength-meter-using-html-css.html*/
      const indicator = document.querySelector(".indicator");
      const input = document.querySelector("#pwd");
      const weak = document.querySelector(".weak");
      const medium = document.querySelector(".medium");
      const strong = document.querySelector(".strong");
      //const text = document.querySelector(".text");
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

$(document).ready(function() {
  $("form").submit(function(event) {
    event.preventDefault();
    //$(".needs-validation").addClass("was-validated");
    var name = $("#name").val();
    var email = $("#email").val();
    var uid = $("#uid").val();
    var pwd = $("#pwd").val();
    var pwdcf = $("#pwdcf").val();
    var submit = $("#submit").val();
    $("#alert-wrap").load("includes/signup.inc.php", {
        name: name,
        email: email,
        uid: uid,
        pwd: pwd,
        pwdcf: pwdcf,
        submit: submit
    });
  });
});
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
</body>

</html>