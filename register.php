
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
				var username = document.getElementById("username");
				function validatePassword(){
					//Check that password and confirmPassword match
					if(password.value != passwordConfirm.value) {
						passwordConfirm.setCustomValidity("Passwords Don't Match");

						//Check for at least one upper case character
						var upperCase = /[A-Z]/g;
						if(password.value.match(upperCase)) {
							password.setCustomValidity('');

							//Check for at least one lower case character
							var lowerCase = /[a-z]/g;
							if(password.value.match(lowerCase)) {
								password.setCustomValidity('');
								//Check for at least one numerical character
								var numbers = /[0-9]/g;
								if(password.value.match(numbers)){
									password.setCustomValidity('');

									//Check that password is at least 8 characters long
									if(password.value.length >= 8){
										password.setCustomValidity('');

										//Check if password is the same as username
										if (password.value != username.value){
											password.setCustomValidity('');
										}

										else if (password.value == username.value){
											passwordConfirm.setCustomValidity('Password cannot be the same as username');
										}
										
									}
									else if(password.value.length < 8){
										password.setCustomValidity('Password must be at least 8 characters long');
									}
								}
								else if (!password.value.match(numbers)){
										password.setCustomValidity('Password must contain at least one number');
								}
							} 
							else if(!password.value.match(lowerCase)){
									password.setCustomValidity('Password must contain at least one lower case letter');
								}
						} 
						else if(!password.value.match(upperCase)){
								password.setCustomValidity('Password must contain at least one upper case letter');
							}
					} 
					else {
						passwordConfirm.setCustomValidity('');
					}
				}
				password.onkeyup = validatePassword;
				passwordConfirm.onkeyup = validatePassword;
				</script>

			 </div>
			  
			</form>


		</body>
	</html>