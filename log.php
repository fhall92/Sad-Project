<?php
require "header.php";

if (!isset($_SESSION['id']) && $_SESSION['username'] != 'ADMIN') {
	header("Location: ../sadproject/main_page.php?error=UnauthorisedAccessAdminOnly");
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
			<li><a href="log.php"> LOG </a></li>
		</ul>
	</div>

	<h1>
		<center>LOG</center>
	</h1>

	



</body>

</html>