<?php
require "header.php";
include "salt_function.php";

//If user has accessed register_action.php via submit button on register.php
if (isset($_GET['change-password-submit'])) {
    require 'dbh.php';

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $_SESSION['username'];
    $oldPassword = $_GET['oldPassword'];
    $newPassword = $_GET['newPassword'];
    $csrfToken = $_GET['csrfToken'];
    echo $csrfToken;

    if (!$SESSION['csrfToken']  == $csrfToken) {
        session_unset();
        session_destroy();
        header("Location: home.php?error=WrongCSRFToken");
        exit();
    }


    //IF Old username & password combination are valid
    // Re-register that user's password

    //--------Error Handling--------
    //Empty forms 
    if (empty($oldPassword) || empty($newPassword)) {
        header("Location: home.php?error=emptyfields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: login.php?error=sqlerror1");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            //If $result holds a value
            if ($row = mysqli_fetch_assoc($result)) {

                //Salt and Hash Old Password
                $salt = $row['salt'];
                $saltedPassword = $salt . $oldPassword;
                $passwordHash = Md5($saltedPassword);


                //If Passwords don't match
                if ($passwordHash == $row['password']) {
                    $passwordCheck = true;
                } else {
                    $passwordCheck = false;
                }
                if ($passwordCheck == false) {

                    echo "<script>
                    alert ('Old Password is incorrect');
                    window.location.href = 'change_password.php';
                            </script>";
                } else {
                    //Register new Password, Kill session, redirect to login
                    $sql = "UPDATE users SET password=? WHERE username=?";
                    $stmt = mysqli_stmt_init($conn);

                    //If sql fail
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: change_password.php?error=sqlerror2");
                        exit();
                    } else {

                        $saltedNewPassword = $salt . $newPassword;
                        $newPasswordHash = md5($saltedNewPassword);
                        mysqli_stmt_bind_param($stmt, "ss", $newPasswordHash, $username);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_store_result($stmt);

                        session_unset();
                        session_destroy();
                        header("Location: home.php");
                        exit();
                    }
                }
            }

            //if $result is empty
            else {
                echo "<script>
                alert ('The username ' + '$username' + 
                        ' and password combination cannot be authorised');
                window.location.href = 'login.php';
                </script>";


                //exit();
            }
        }
    }
}

//If user accesses page from outside of change_password.php, redirect to home.php
else {
    header("Location: home.php");
    exit();
}
