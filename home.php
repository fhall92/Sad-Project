<?php
	require "header.php";
	require "dbh.php";
	?>
<!DOCTYPE html>
		
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
			
			<h1><center>Home</center></h1>
			
			<center>
			<h2>
			<p>SAD PROJECT 2019/2020<br>
			STUDENT NAME: FRANCIS HALL<br>
			STUDENT NUMBER: C00220910<br>
			<br>

			<?php
			//If user is already logged in, redirect to main_page
			if(isset($_SESSION['id'])){
				header("Location: ../sadproject/main_page.php");
			}

			else{
				echo 'YOU ARE CURRENTLY LOGGED OUT<br>';
				echo 'PLEASE REGISTER OR LOGIN ABOVE<br>';
				
			}
			?>

			</h2>
			
			</center>



		</body>
	</html>