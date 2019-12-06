<?php
require "header.php";
include "salt_function.php";
include "sanitise_function.php";

//If user has accessed register_action.php via submit button on register.php
if (isset($_POST['register-submit'])) {
    require 'dbh.php';

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    $username = Sanitise($username);
    //--------Error Handling--------
    //Empty forms
    if (empty($username) || empty($password) || empty($passwordConfirm)) {
        header("Location: register.php?error=emptyfields");
        exit();
    } else {
        //Check if user already exists in db
        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: register.php?error=sqlerror1");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0) {
                header("Location: register.php?error=useralreadyexists");
                exit();
            }
            //Else, register user
            else {
                $sql = "INSERT INTO users(username, password, salt) VALUES (?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                //If registration fails, redirect to register.php
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: register.php?error=sqlerror2");
                    exit();
                } else {

                    //Salt and Hash Password
                    $salt = CreateSalt(10);
                    $saltedPassword = $salt . $password;
                    $passwordHash = Md5($saltedPassword);

                    mysqli_stmt_bind_param($stmt, "sss", $username, $passwordHash, $salt);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("Location: register.php?registration=success");
                    exit();
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

//If user accesses page from outside of register.php, redirect to register.php
else {
    header("Location: register.php");
    exit();
}
