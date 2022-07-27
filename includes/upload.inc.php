<?php
if (isset($_POST['profile_submit'])) {
    $file = $_FILES['file'];
    $uid = $_POST['uid'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 2000000) {
                echo "good";
                //$fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileNameNew = $uid.'.'.$fileActualExt;
                $fileDestination = '../src/profile/'. $fileNameNew;
                uploadProfileImg($conn, $uid, $fileActualExt);
                move_uploaded_file($fileTmpName, $fileDestination);
            } else {
                header('location: ../profile.php?error=filetoobig');
                exit();
            }
        } else {
            header('location: ../profile.php?error=uploaderror');
            exit();
        }
    } else {
        header('location: ../profile.php?error=invalidfiletype');
        exit();
    }
}
else {
    header('location: ../profile.php?error=uploaderror');
    exit();
}