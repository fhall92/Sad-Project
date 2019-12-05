<?php

require 'header.php';

if (!isset($_SESSION['id'])) {
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
			<li><a href="page1.php"> Page 1 </a></li>
			<li><a href="page2.php"> Page 2 </a></li>
			<li><a href="change_password.php"> Change Password </a></li>
			<li><a href="log.php"> LOG </a></li>
		</ul>
	</div>


	<center>
		<h1>Page 2</h1><br><br>
			<h2>This is another page that only an authenticated
			user should be able to view.</h2>
	</center>
</body>

</html>