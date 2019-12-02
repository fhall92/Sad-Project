<?php
	require "header.php";
	?>

<!DOCTYPE html>
		
		<head>
			<link rel="stylesheet" type="text/css" href="stylesheet.css">
			
		</head>
			
		<body>
			<div class="navbar">		
				<ul>
				<ul>
					<li><a href="logout.php"> Logout </a></li>
					<li><a href="page1.php"> page1 </a></li>
					<li><a href="page2.php"> page2 </a></li>
					<li><a href="change_password.php"> Change Password </a></li>
					<li><a href="log.php"> LOG </a></li>
				</ul>

				</ul>
			</div>
			
			<h1><center>Main Page</center></h1>
			
			<center>
			<h2>
			<p>SAD PROJECT 2019/2020<br>
			STUDENT NAME: FRANCIS HALL<br>
			STUDENT NUMBER: C00220910<br>
			<br>
			<?php

			//If user is not logged in, redirect to home.php
			if(isset($_SESSION['id'])){
				echo 'Welcome '.$_SESSION['username'].'<br>';
				echo 'YOU ARE LOGGED IN<br>';			
			}

			else{
				header("Location: ../sadproject/home.php?error=UnauthorisedAccess");
			}
			?>
			</h2>
			
			</center>



		</body>
	</html>