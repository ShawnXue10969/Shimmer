<?php
/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/vendor/phpmailer/phpmailer/src/Exception.php';
require '../phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
*/
function emptyInputSignup($name, $email, $username, $pwd, $pwdcf) {
    $result;
    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdcf)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidEmail($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdcf) {
    $result;
    if ($pwd !==  $pwdcf) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function updateName($conn, $uid, $name) {
    $sql = "UPDATE users SET userFullName = '".$name."' WHERE userId = ".$uid.";";
    $result = mysqli_query($conn, $sql);
}

function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE userUid = ? OR userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function uploadProfileImg($conn, $uid, $ext) {
    $sql = "SELECT * FROM profiles WHERE userId = ".$uid.";";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)) {
        $path = '../src/profile/'.$uid.'.'.$row["type"];
        unlink($path);
        $sql = "UPDATE profiles SET type = '".$ext."' WHERE userId = ".$uid.";";
        $result = mysqli_query($conn, $sql);
        header('location: ../profile.php');
    }
    else {
        $sql = "INSERT INTO profiles (userId, type) VALUES (".$uid.", '".$ext."');";
        //mysqli_query($conn, $sql);
        echo $sql;
        $result = mysqli_query($conn, $sql);
        echo $result;
        header('location: ../profile.php');
    }
}

function updatePassword($conn, $uid, $pwd) {
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET userPwd = '".$hashedPwd."' WHERE userId = ".$uid.";";
    $result = mysqli_query($conn, $sql);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $sql = "INSERT INTO users (userFullName, userEmail, userUid, userPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "
        <div class='alert alert-danger' role='alert'>
            Something went wrong, please try again.
        </div>
        ";
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo "
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
        Signup successful!
        <a href='login.php' class='alert-link'>Log in</a>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>
    ";
    exit();
}

function loginUser($conn, $username, $pwd, $remember) {
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["userPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        if ($remember) {
            setcookie("uid", $username, time() + 3600 * 24 * 7, "/");
            setcookie("pwd", $pwd, time() + 3600 * 24 * 7, "/");
        }
        else {
            setcookie("uid", "", -1, '/');
            setcookie("pwd", "", -1, '/');
        }
        $_SESSION["userid"] = $uidExists["userId"];
        $_SESSION["useruid"] = $uidExists["userUid"];
        header("location: ../index.php");
        exit();
    }
}

function pwdReset($conn, $email, $selector, $token, $expires, $url) {
    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pwdreset.php?error=stmtfailed");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../pwdreset.php?error=stmtfailed");
        exit();
    }
    else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close();
    
    $message = '<p>Click the link to reset password for your Shimmer account. If you did not make this request, please ignore this email.</p>';
    $message .= '<p>Your password reset link: </br>';
    $message .= '<a href="' . $url . '">' . $url . '</a></p>';
    /*
    $this->load->library('email');

    $config = Array(

        'protocol' => 'smtp',
       
        'smtp_host' => 'mailhub.eait.uq.edu.au',
       
        'smtp_port' => 25,
       
        'mailtype' => 'html',
       
        'charset' => 'iso-8859-1',
       
        'wordwrap' => TRUE ,
       
        'mailtype' => 'html',
       
        'starttls' => true,
       
        'newline' => "\r\n"
    
    );
    
    $this->email->initialize($config);

    $this->email->from(get_current_user().'@student.uq.edu.au', 'Shimmer');
   
    $this->email->to($email);
   
    $this->email->subject('Reset your password for Shimmer');

    $this->email->message($message);

    $this->email->send();
*/
/*
    $to_email = $email;
    $subject = 'Reset your password for Shimmer';
    $body = $message;
    $headers = 'From: shimmer <useshimmer@gmail.com>\r\n';
    $headers .= 'Reply-to: useshimmer@gmail.com\r\n';
    $headers .= 'Content type: text/html\r\n';

    if(mail($to_email, $subject, $body, $headers)) {
        echo "success";
    }
    else {
        echo "failed";
        exit();
    }
    */

//Mail function for localhost testing
/*
    require 'phpmailer/PHPMailerAutoload.php';


    $mail = new PHPMailer();

    try {
        $mail->SMTPDebug = 2;      
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        //$mail->SMTPSecure = 'ssl';
        $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
        //$mail->SMTPAutoTLS = false;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->Username = 'useshimmer@gmail.com';
        $mail->Password = 'xatemzagglhbaopp';
        $mail->SetFrom('useshimmer@gmail.com', 'Shimmer');
        $mail->Subject = 'Reset your password for Shimmer';
        $mail->Body = $message;
        $mail->AddAddress($email);
        $mail->addReplyTo('useshimmer@gmail.com');

        $mail->send();
    } catch (Exception $e) {
        header("Location: ../pwdreset.php?error=stmtfailed");
        exit();
    }
    */
    

    header("Location: ../pwdreset.php?error=none");
}

function newPwd($conn, $selector, $validator, $currentDate, $pwd) {
    $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        echo "
            <div class='alert alert-warning' role='alert'>
                Something went wrong! 
                <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
            </div>
        ";
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($result)) {
            echo "
                <div class='alert alert-warning' role='alert'>
                    Please
                    <a href='pwdreset.php?error=resubmit' class='alert-link'>re-submit</a>
                    your request!1
                </div>
            ";
            exit();
        }
        else {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row["pwdResetToken"]);

            if ($tokenCheck === false) {
                echo "
                    <div class='alert alert-warning' role='alert'>
                        Please
                        <a href='pwdreset.php?error=resubmit' class='alert-link'>re-submit</a>
                        your request!2
                    </div>
                ";
                exit();
            }
            else if ($tokenCheck === true) {
                $tokenEmail = $row['pwdResetEmail'];

                $sql = "SELECT * FROM users WHERE userEmail=?;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "
                        <div class='alert alert-warning' role='alert'>
                            Please
                            <a href='pwdreset.php?error=resubmit' class='alert-link'>re-submit</a>
                            your request!3
                        </div>
                    ";
                    exit();
                }
                else {
                    mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($result)) {
                        echo "
                            <div class='alert alert-warning' role='alert'>
                                Something went wrong! 
                                <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
                            </div>
                        ";
                        exit();
                    }
                    else {
                        $sql = "UPDATE users SET userPwd=? WHERE userEmail=?";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $sql)) {
                            echo "
                                <div class='alert alert-warning' role='alert'>
                                    Something went wrong! 
                                    <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
                                </div>
                            ";
                            exit();
                        }
                        else {
                            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)) {
                                echo "
                                    <div class='alert alert-warning' role='alert'>
                                        Something went wrong! 
                                        <a href='pwdreset.php?error=resubmit' class='alert-link'>Re-submit your request</a>
                                    </div>
                                ";
                                exit();
                            }
                            else {
                                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                                mysqli_stmt_execute($stmt);
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                        Password reset successful!
                                        <a href='login.php' class='alert-link'>Log in</a>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                ";
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
}