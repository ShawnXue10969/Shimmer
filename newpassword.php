<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
            <form novalidate class="needs-validation" action="includes/newpassword.inc.php" method="POST">
              <div id="alert-wrap">
                    
              </div>
                <?php

                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "validationfailed") {
                        echo "
                        <div class='alert alert-danger' role='alert'>
                            Failed to validate your request.
                            </br>
                            <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
                        </div>
                        ";
                    }
                }
                else if (!isset($_GET["selector"]) || !isset($_GET["validator"])) {
                    header("location: newpassword.php?error=validationfailed");
                }
                else {
                    $selector = $_GET["selector"];
                    $validator = $_GET["validator"];
                    if (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
                        ?>
                        <input id="selector" type="hidden" name="selector" value="<?php echo $selector ?>">
                        <input id="validator" type="hidden" name="validator" value="<?php echo $validator ?>">
                        <div class="form-floating mt-3 input-wrap">
                          <input id="pwd" class="form-control" onkeyup="trigger()" id="pwd" type="password" name="pwd" placeholder=" " required>
                          <label for="pwd">New Password</label>
                        </div>
                        <div class="form-floating mt-3 indicator">
                            <span class="weak"></span>
                            <span class="medium"></span>
                            <span class="strong"></span>
                        </div>
                        <div class="form-floating mt-3 input-wrap">
                            <input id="pwdcf" type="password" class="form-control" name="pwdcf" placeholder=" " required>
                            <label for="pwdcf">Confirm New Password</label>
                        </div>
                        <button id="newpwd_submit" type="submit" name="newpwd_submit" class="mt-3 btn btn-primary yellow">Reset password</button>
                        <?php
                    }
                    else {
                      ?>
                      <div class='alert alert-danger' role='alert'>
                          Failed to validate your request.
                          </br>
                          <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
                      </div>
                      <?php
                    }
                }
                ?>
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
        var selector = $("#selector").val();
        var validator = $("#validator").val();
        var pwd = $("#pwd").val();
        var pwdcf = $("#pwdcf").val();
        var newpwd_submit = $("#newpwd_submit").val();
        $("#alert-wrap").load("includes/newpassword.inc.php", {
          selector: selector,
          validator: validator,
          pwd: pwd,
          pwdcf: pwdcf,
          newpwd_submit: newpwd_submit
        });
      });
    });
</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
</body>

</html>