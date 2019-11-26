<?php 
//If user has accessed register_action.php via submit button on register.php
if (isset($_POST['register-submit'])){
    require 'dbh.php';
    

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $databasename);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];
    



    //--------Error Handling--------

    //Empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
    if(empty($username) || empty($password) || empty($passwordConfirm)){
        header("Location: ../sadproject/register.php?error=emptyfields");
        exit();
    }

    //Only allow a-z, A-Z, 0-9 in username
    //else if(!preg_match("/^[a-zA-Z0-9]*$/")){
    //    header("Location: ../sadproject/register.php?error=invalidusername&username=".$username);
    //    exit();
    //}
   
    //If no errors caught, check if user already exists in db
    else{

        $sql = "SELECT username FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../sadproject/register.php?error=sqlerror1");
            exit();
        }

        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if($resultCheck > 0){
                header("Location: ../sadproject/register.php?error=useralreadyexists");
                exit();
            }
            //Else, register user
            else{
                $sql = "INSERT INTO users(username, password) VALUES (?, ?)";
                $stmt = mysqli_stmt_init($conn);
                
                //If registration fails, redirect to register.php
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    header("Location: ../sadproject/register.php?error=sqlerror2");
                    exit();
                }

                else{
                    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    header("Location: ../sadproject/register.php?registration=success");
                    exit();
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}

//If user accesses page from outside of register.php, redirect to register.php
else{
    header("Location: ../sadproject/register.php");
    exit();
}