<?php

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdcf = $_POST["pwdcf"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $nameErr = false;
    $emailErr = false;
    $uidErr = false;
    $pwdErr = false;
    $pwdcfErr = false;
    
    $emptyInputs = false;
    $invalid = false;

    
    if (empty($name)) {
        $nameErr = true;
        $emptyInputs = true;
    }
    if (empty($email)) {
        $emailErr = true;
        $emptyInputs = true;
    }
    if (empty($username)) {
        $uidErr = true;
        $emptyInputs = true;
    }
    if (empty($pwd)) {
        $pwdErr = true;
        $emptyInputs = true;
    }
    if (empty($pwdcf)) {
        $pwdcfErr = true;
        $emptyInputs = true;
    }
    
    if ($emptyInputs !== false) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Please fill in all fields!
        </div>
        ";
        $invalid = true;
    }
    
    if (invalidUid($username) !== false) {
        if ($invalid == false) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Please choose a proper username!
            </div>
            ";
        }
        $uidErr = true;
        $invalid = true;
    }
    if (invalidEmail($email) !== false) {
        if ($invalid == false) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Please choose a proper email!
            </div>
            ";
        }
        $emailErr = true;
        $invalid = true;
    }
    if (pwdMatch($pwd, $pwdcf) !== false) {
        if ($invalid == false) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Passwords don't match!
            </div>
            ";
        }
        $pwdcfErr = true;
        $invalid = true;
    }
    if (uidExists($conn, $username, $email) !== false) {
        if ($invalid == false) {
            echo "
            <div class='alert alert-danger' role='alert'>
                Username or email already exists!
            </div>
            ";
        }
        $uidErr = true;
        $emailErr = true;
        $invalid = true;
    }
?>
<script>
    var nameErr = "<?php echo $nameErr; ?>";
    var emailErr = "<?php echo $emailErr; ?>";
    var uidErr = "<?php echo $uidErr; ?>";
    var pwdErr = "<?php echo $pwdErr; ?>";
    var pwdcfErr = "<?php echo $pwdcfErr; ?>";
    var invalid = "<?php echo $invalid; ?>";
    
    if (nameErr == true) {
        $("#name").removeClass("is-valid");
        $("#name").addClass("is-invalid");
    }
    else {
        $("#name").removeClass("is-invalid");
        $("#name").addClass("is-valid");
    }
    if (emailErr == true) {
        $("#email").removeClass("is-valid");
        $("#email").addClass("is-invalid");
    }
    else {
        $("#email").removeClass("is-invalid");
        $("#email").addClass("is-valid");
    }
    if (uidErr == true) {
        $("#uid").removeClass("is-valid");
        $("#uid").addClass("is-invalid");
    }
    else {
        $("#uid").removeClass("is-invalid");
        $("#uid").addClass("is-valid");
    }
    if (pwdErr == true) {
        $("#pwd").removeClass("is-valid");
        $("#pwd").addClass("is-invalid");
    }
    else {
        $("#pwd").removeClass("is-invalid");
        $("#pwd").addClass("is-valid");
    }
    if (pwdcfErr == true) {
        $("#pwdcf").removeClass("is-valid");
        $("#pwdcf").addClass("is-invalid");
    }
    else {
        $("#pwdcf").removeClass("is-invalid");
        $("#pwdcf").addClass("is-valid");
    }

    if (invalid == false) {
        $("#name, #email, #uid, #pwd, #pwdcf").val("");
        indicator.style.display = "none";
        $("#name").removeClass("is-valid");
        $("#uid").removeClass("is-valid");
        $("#email").removeClass("is-valid");
        $("#pwd").removeClass("is-valid");
        $("#pwdcf").removeClass("is-valid");
    }
</script>
<?php
    if ($invalid == false) {
        createUser($conn, $name, $email, $username, $pwd);
        echo "
            <div class='alert alert-success alert-dismissible fade show' role='alert'>
                Signup successful!
                <a href='login.php' class='alert-link'>Log in</a>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
}
else {
    header("location: ../signup.php");
    exit();
}
