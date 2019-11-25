
<?php
	$servername = "localhost";
	$username = "root";  //your user name for php my admin if in local most probaly it will be "root"
	$password = "";  //password probably it will be empty
	$databasename = "registration"; //Your db nane
	// Create connection
	$conn = new mysqli($servername, $username, $password,$databasename);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	echo "Connected successfully";
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