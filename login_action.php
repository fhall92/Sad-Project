<?php
	require "header.php";

	//Ensure user accessed page by clicking submit button on login.php
	if(isset($_POST['login-submit'])){

		require 'dbh.php';
		$username = $_POST['username'];
    	$password = $_POST['password'];

		//Check for empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
		if(empty($username) || empty($password)){
			header("Location: ../sadproject/login.php?error=emptyfields");
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
					if($password != $row[password]){
						header("Location: ../sadproject/login.php?error=incorrectPassword");
						exit();
					}

					else{
						//Create Session
						session_start();
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];

						header("Location: ../sadproject/home.php?login=success");
					}
				}

				//if $result is empty
				else{
				header("Location: ../sadproject/login.php?error=nouser");
				exit();
				}
			}
		}	
	}

	//If user has accessed page without clicking submit on login.php
	else{
		header("Location: ../sadproject/login.php");
		exit();
	}
