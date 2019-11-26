<?php 

if (isset($_POST['register-submit'])){
    require 'dbh.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    //--------Error Handling--------

    //Empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
    if(empty($username) || empty($password) || empty($passwordConfirm)){
        header("Location: ../register.php?error=emptyfields&username=".$username);
        exit();
    }

    //Only allow a-z, A-Z, 0-9 in username
    else if(!preg_match("/^[a-zA-Z0-9]*$/")){
        header("Location: ../register.php?error=invalidusername&username=".$username);
    }
   
    //If no errors caught, check if user already exists in db
    else{

        $sql = "SELECT users FROM registration WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../register.php?error=sqlerror");
            exit();
        }

        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli)stmt_num_rows($stmt);
        }
    }

}