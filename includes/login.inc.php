<?php

if (isset($_POST['login-submit'])) {

    require 'dbh.inc.php';
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];

    //Check to see if mail or password input is empty
    if(empty($mailuid) || empty($password)) {
        header("Location: ../index.php?error=emptyfields");
        exit();        
    } else {
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if($row = mysqli_fetch_assoc($result)) {

                // Check to make sure password given matches password on DB
                $pwdCheck = password_verify($password, $row['pwdUsers']);

                // The if below checks for the validity of password, if incorrect sends back to page w/ error msg
                if($pwdCheck == false) {
                    header("Location: ../index.php?error=invalidpwd");
                    exit();

                } else if($pwdCheck == true) {
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUid'] = $row['uidUsers'];

                    header("Location: ../index.php?login=success");
                    exit();

                } else {
                    header("Location: ../index.php?error=invalidpwd");
                    exit();
                }

            } else {
                header("Location: ../index.php?error=nouser");
                exit();
            }
        }
    }

} else {
    header("Location: ../index.php");
    exit();
}