<?php
    require "header.php";
    
    if(!isset($_SESSION['id'])){
        header("Location: ../sadproject/home.php?error=UnauthorisedAccess");
    }
?>

<!DOCTYPE html>
		
		<head>
			<link rel="stylesheet" type="text/css" href="stylesheet.css">
			
		</head>
			
		<body>
			<div class="navbar">		
				<ul>
					<li><a href="logout.php"> Logout </a></li>
					<li><a href="page1.php"> page1 </a></li>
					<li><a href="page2.php"> page2 </a></li>
					<li><a href="change_password.php"> Change Password </a></li>
				</ul>
			</div>
			
			<h1><center>Change Password</center></h1>
			
			<center>
            <form onsubmit="return validatePassword()" action="change_password_action.php" method="post">

			<div class="container">
				<label for="oPsw"><b>Old Password</b></label>
				<input type="password" placeholder="Enter Old Password" name="oldPassword" onkeypress="validatePassword();" id="oldPassword" required>

                <label for="nPsw"><b>New Password</b></label>
				<input type="password" placeholder="Enter New Password" name="newPassword" onkeypress="validatePassword();" id="newPassword" required>

                <label for="pswConfirm"><b>Confirm New Password</b></label>
				<input type="password" placeholder="Confirm New Password" name="passwordConfirm" onkeypress="validatePassword();" id="passwordConfirm" required>

				<button type="submit" name="change-password-submit">Change Password</button>


                <!-- Password Validation -->
				<script>
                var oldPassword = document.getElementById("oldPassword"), 
                newPassword = document.getElementById("newPassword"),
				passwordConfirm = document.getElementById("passwordConfirm");
				
				function validatePassword(){
					//Check that password and confirmPassword match
					if(newPassword.value != passwordConfirm.value) {
						passwordConfirm.setCustomValidity("Passwords Don't Match");

						//Check for at least one upper case character
						var upperCase = /[A-Z]/g;
						if(newPassword.value.match(upperCase)) {
							newPassword.setCustomValidity('');

							//Check for at least one lower case character
							var lowerCase = /[a-z]/g;
							if(newPassword.value.match(lowerCase)) {
								newPassword.setCustomValidity('');
								//Check for at least one numerical character
								var numbers = /[0-9]/g;
								if(newPassword.value.match(numbers)){
									newPassword.setCustomValidity('');

									//Check that password is at least 8 characters long
									if(newPassword.value.length >= 8){
										newPassword.setCustomValidity('');
									}
									else if(newPassword.value.length < 8){
										newPassword.setCustomValidity('Password must be at least 8 characters long');
									}
								}
								else if (!newPassword.value.match(numbers)){
										newPassword.setCustomValidity('Password must contain at least one number');
								}
							} 
							else if(!newPassword.value.match(lowerCase)){
									newPassword.setCustomValidity('Password must contain at least one lower case letter');
								}
						} 
						else if(!newPassword.value.match(upperCase)){
								newPassword.setCustomValidity('Password must contain at least one upper case letter');
							}
					} 
					else {
						passwordConfirm.setCustomValidity('');
					}
				}
				newPassword.onkeyup = validatePassword;
				passwordConfirm.onkeyup = validatePassword;
				</script>



			 </div>

			</form>
			
			</center>



		</body>
	</html>