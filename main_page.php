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
					<li><a href="logout.php"> Logout </a></li>
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