<?php

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

			if(!mysqli_stmt_prepare($stmt)){
				header("Location: ../sadproject/login.php?error=sqlerror1");
				exit();
			}
		}


		
	}

	//If user has accessed page without clicking submit on login.php
	else{
		header("Location: ../sadproject/login.php");
		exit();
	}
