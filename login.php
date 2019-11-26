
<?php
	require "header.php";
	require "dbh.php";
	
	//If user is already logged in, redirect to main_page
	if(isset($_SESSION['id'])){
		header("Location: ../sadproject/main_page.php");
	}
?>

	<!DOCTYPE html>
	<html>
		
		<head>
			<link rel="stylesheet" type="text/css" href="stylesheet.css">
		</head>
			
		<body>
			
			<div class="navbar">		
				<ul>
					<li><a href="home.php"> Home</a></li>
					<li><a href="login.php"> Login </a></li>
					<li><a href="register.php"> Register </a></li>
				</ul>
			</div>
			
			<h1><center>LOGIN</center></h1>


			<form action="login_action.php" method="post">

			<div class="container">
				<label for="uname"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="username" required>

				<label for="psw"><b>Password</b></label>
				<input type="password" placeholder="Enter Password" name="password" required>

				<button type="submit" name="login-submit">Login</button>

			 </div>

			</form>

		</body>
	</html>