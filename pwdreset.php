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
      <form class="login-form" action="includes/pwdreset.inc.php" method="POST">
        <?php
        
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "stmtfailed") {
                echo "
                <div class='alert alert-danger' role='alert'>
                    Something went wrong, please try again.
                </div>
                ";
            }
            else if ($_GET["error"] == "resubmit") {
              echo "
              <div class='alert alert-danger' role='alert'>
                  Please re-submit your request!
              </div>
              ";
            }
            else if ($_GET["error"] == "none") {
                echo "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Please check your e-mail!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                ";
            }
        }

        ?>
        <div class="mt-3 input-wrap login-wrap">
          <i class="fas fa-envelope"></i>
          <input type="email" name="email" placeholder="Email" required>
        </div>
        <button type="submit" name="pwdreset-request" class="mt-3 btn btn-primary yellow">Reset password</button>
      </form>
    </section>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
</body>

</html>