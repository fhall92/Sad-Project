<?php
require "header.php";
require "dbh.php";
include "salt_function.php";

//Create ADMIN user if none exists
$adminUsername = "ADMIN";
$adminPassword = "SAD_2019!";

//Check if ADMIN already exists in db
$sql = "SELECT username FROM users WHERE username=?";
$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
	//header("Location: ../sadproject/home.php?error=sqlerror1");
	exit();
} else {
	mysqli_stmt_bind_param($stmt, "s", $adminUsername);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	$resultCheck = mysqli_stmt_num_rows($stmt);

	if ($resultCheck > 0) {
		echo "--ADMIN user already exists--";
	}
	//Else, register user
	else {

		$sql = "INSERT INTO users(username, password, salt) VALUES (?, ?, ?)";
		$stmt = mysqli_stmt_init($conn);

		//If registration fails, redirect to home.php
		if (!mysqli_stmt_prepare($stmt, $sql)) {
			//header("Location: ../sadproject/home.php?error=sqlerror2");

		} else {

			//Salt and Hash Password
			$adminSalt = CreateSalt(10);
			$adminSaltedPassword = $adminSalt.$adminPassword;
			$passwordHash = md5($adminSaltedPassword);
			mysqli_stmt_bind_param($stmt, "sss", $adminUsername, $passwordHash, $adminSalt);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			echo "--ADMIN user created-- $passwordHash";
		}
	}
}



//If user is already logged in, redirect to main_page
if (isset($_SESSION['id'])) {
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

	<h1>
		<center>LOGIN</center>
	</h1>


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