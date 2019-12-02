<?php 
    require "header.php";
    
//If user has accessed register_action.php via submit button on register.php
if (isset($_POST['change-password-submit'])){
    require 'dbh.php';
    
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $username = $_SESSION['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];


    //IF Old username & password combination are valid
        // Re-register that user's password
    
    //--------Error Handling--------
    //Empty forms 
    if(empty($oldPassword) || empty($newPassword)){
        header("Location: ../sadproject/home.php?error=emptyfields");
        exit();
    }
   
    else{
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt = mysqli_stmt_init($conn);
        
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../sadproject/login.php?error=sqlerror1");
            exit();
        }

        else{
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            //If $result holds a value
            if($row = mysqli_fetch_assoc($result)){
                
                //If Passwords don't match
                $passwordCheck = password_verify($oldPassword, $row['password']);
                if($passwordCheck == false){

                    echo "<script>
                    alert ('Old Password is incorrect');
                    window.location.href = 'change_password.php';
                            </script>";			
                }

                else{
                    //Register new Password, Kill session, redirect to login
                    
                }
            }

            //if $result is empty
            else{
                echo "<script>
                alert ('The username ' + '$usernameSanitize' + 
                        ' and password combination cannot be authorised');
                window.location.href = 'login.php';
                </script>";

                
            //exit();
            }
        }
    }	
}

//If user accesses page from outside of change_password.php, redirect to home.php
else{
    header("Location: ../sadproject/home.php");
    exit();
}