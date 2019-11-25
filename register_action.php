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
   
    //If no errors caught, register the user
    else{

        $sql = "SELECT users FROM registration WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../")
        }
        
    }

}