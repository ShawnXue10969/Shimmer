<?php

if (isset($_POST["change_name"])) {
    $name = $_POST["name"];
    $uid = $_POST["uid"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    $nameErr = false;

    if (empty($name)) {
        $nameErr = true;
        echo "
        <div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Please fill in a new name!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
    ?>
    <script>
        var nameErr = "<?php echo $nameErr; ?>";
        if (nameErr == true) {
            $("#name").removeClass("is-valid");
            $("#name").addClass("is-invalid");
        }
        else {
            $("#name").removeClass("is-invalid");
            $("#name").val("");
            document.querySelector("#name-lable").innerHTML = <?php echo "Full name: ".$name; ?>;
        }
    </script>
<?php
    if ($nameErr == false) {
        updateName($conn, $uid, $name);
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Your name has been updated!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
}
else if (isset($_POST["change_pwd"])) {
    $pwd = $_POST["pwd"];
    $pwdcf = $_POST["pwdcf"];
    $uid = $_POST["uid"];

    require_once 'dbh.inc.php';
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
        if (invalid == false) {
            $("#pwd, #pwdcf").val("");
            indicator.style.display = "none";
            $("#pwd").removeClass("is-valid");
            $("#pwdcf").removeClass("is-valid");
        }
    </script>
    <?php
    if ($invalid == false) {
        updatePassword($conn, $uid, $pwd);
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            Your password has been updated!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
}
else {
    echo "Please log in first.";
    exit();
}