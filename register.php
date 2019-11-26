
<?php
	$servername = "localhost";
	$dbusername = "root";  //your user name for php my admin if in local most probaly it will be "root"
	$dbpassword = "";  //password probably it will be empty
	$databasename = "registration"; //Your db name
	// Create connection
	$conn = mysqli_connect($servername, $dbusername, $dbpassword,$databasename);
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
			
			<h1><center>REGISTER</center></h1>



			<form onsubmit="return validatePassword()" action="register_action.php" method="post">

			<div class="container">
				<label for="uname"><b>Username</b></label>
				<input type="text" placeholder="Enter Username" name="username" required>

				<label for="psw"><b>Password</b></label>
				<input type="password" onkeypress="validatePassword();" placeholder="Enter Password" name="password" id="password" required>
				
				<label for="passwordConfirm"><b>Confirm Password</b></label>
				<input type="password" placeholder="Confirm Password" onkeypress="validatePassword();" name="passwordConfirm" id="passwordConfirm" required>

				<button type="submit" name="register-submit">Register</button>

				<!-- Password/Confirm Password Validation -->
				<script>
				var password = document.getElementById("password"), 
				passwordConfirm = document.getElementById("passwordConfirm");

				function validatePassword(){
					if(password.value != passwordConfirm.value) {
						passwordConfirm.setCustomValidity("Passwords Don't Match");
					} 
					else {
						passwordConfirm.setCustomValidity('');
					}
				}

				password.onchange = validatePassword;
				passwordConfirm.onkeyup = validatePassword;
				</script>

			 </div>
			  
			</form>


		</body>
	</html>