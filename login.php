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
</head>

<body>
  <div class="container-fluid">
    <section class="form-wrap">
      <div class="d-flex mb-3 justify-content-center">
        <a href="index.php">
          <img class="logo" src="src/images/logo.svg">
        </a>
      </div>
      <form class="login-form" action="includes/login.inc.php" method="POST">

      <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "wronglogin") {
          echo "
          <div class='alert alert-danger' role='alert'>
            Login failed, please try again!
          </div>
          ";
        }
      }
      if (isset($_GET["update"])) {
        if ($_GET["update"] == "success") {
          echo "
          <div class='alert alert-success' role='alert'>
            Password reset successful!
          </div>
          ";
        }
      }
      ?>
        <div class="mt-3 input-wrap login-wrap">
          <i class="fas fa-envelope"></i>
          <input type="text" name="uid" placeholder="Username/Email" value="<?php if(isset($_COOKIE["uid"])) {echo $_COOKIE["uid"]; } ?>" required>
        </div>
        <div class="mt-3 input-wrap login-wrap">
          <i class="fas fa-key"></i>
          <input type="password" name="pwd" placeholder="Password" value="<?php if(isset($_COOKIE["pwd"])) {echo $_COOKIE["pwd"]; } ?>" required>
        </div>
        <div class="mt-2 form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember" <?php if(isset($_COOKIE["uid"])) {echo 'checked'; } ?>>
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <button type="submit" name="submit" class="mt-3 btn btn-primary blue">Login</button>
        <div class="text-center mt-3">
          <span>
            Don't have an account?
            <a href="signup.php">Sign up</a>
          </span>
        </div>
        <div class="text-center">
          <span>
            <a href="pwdreset.php">Forgot password</a>
          </span>
        </div>
      </form>
    </section>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
</body>

</html>