<?php

if (isset($_POST["newpwd_submit"])) {

    $selector = $_POST["selector"];
    $validator = $_POST["validator"];
    $pwd = $_POST["pwd"];
    $pwdcf = $_POST["pwdcf"];

    require_once 'functions.inc.php';

    $pwdErr = false;
    $pwdcfErr = false;
    $emptyInputs = false;
    $invalid = false;

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

    $currentDate = date("U");

    require_once 'dbh.inc.php';


?>
<script>
    var pwdErr = "<?php echo $pwdErr; ?>";
    var pwdcfErr = "<?php echo $pwdcfErr; ?>";
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
</script>
<?php
    if ($invalid == false) {
        newPwd($conn, $selector, $validator, $currentDate, $pwd);
    }
}
else {
    header("location: ../index.php");
    exit();
}