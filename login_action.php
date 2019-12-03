<?php
require "header.php";

//Ensure user accessed page by clicking submit button on login.php
if (isset($_POST['login-submit'])) {

	require 'dbh.php';
	$username = $_POST['username'];
	$password = $_POST['password'];

	$currentTime = time();
	echo $currentTime;

	$usernameSanitize = filter_var($username, FILTER_SANITIZE_STRIPPED);

	//Check for empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
	if (empty($username) || empty($password)) {
		header("Location: ../sadproject/login.php?error=emptyfields");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE username=?";
		$stmt = mysqli_stmt_init($conn);

		if (!mysqli_stmt_prepare($stmt, $sql)) {
			header("Location: ../sadproject/login.php?error=sqlerror1");
			exit();
		} else {
			mysqli_stmt_bind_param($stmt, "s", $username);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

			//If $result holds a value
			if ($row = mysqli_fetch_assoc($result)) {

				//If Passwords don't match
				$passwordCheck = password_verify($password, $row['password']);
				if ($passwordCheck == false) {

					//Store and Check Login Attempts
					$ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
					$userAgent = $_SERVER['HTTP_USER_AGENT'];

					$failedAttempt = 'INSERT INTO `attempts`(`username`, `ip`, `userAgent`) VALUES (?,?,?)';
					if (mysqli_stmt_prepare($stmt, $failedAttempt)) {
						// Binds variables to a prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "sss", $username, $ip, $userAgent);
						// Executes a prepared Query
						mysqli_stmt_execute($stmt);
					}

					$result = mysqli_query($conn, "SELECT COUNT(*) FROM `attempts` WHERE `username` LIKE '$username'
                                        AND `ip` LIKE '$ip' 
                                        AND `userAgent` LIKE '$userAgent'
                                        AND `isSucess` LIKE 0");
					$_SESSION['count'] = mysqli_fetch_array($result, MYSQLI_NUM);

					if ($_SESSION['count'][0] > 5) {
						echo "You locked out";
					} else {
						if ($_SESSION['count'][0] != 5) {
							echo "you have " . htmlspecialchars((5 - $_SESSION['count'][0]), ENT_QUOTES, 'UTF-8') . " left <br>";
						} else {
							echo "last chance  <br>";
						}
					}

					echo "<script>
						alert ('The username ' + '$username' + 
								' and password combination cannot be authorised');
								//window.location.href = 'login.php';
								</script>";
				} else {
					//Create Session
					session_start();
					$_SESSION['id'] = $row['id'];
					$_SESSION['username'] = $row['username'];

					header("Location: ../sadproject/main_page.php?login=success");
				}
			}

			else{
				echo "<script>
						alert ('The username ' + '$username' + 
								' and password combination cannot be authorised');
								window.location.href = 'login.php';
								</script>";
			}
		}
	}
}

//If user has accessed page without clicking submit on login.php
else {
	header("Location: ../sadproject/login.php?error=UnauthorisedAccess");
	exit();
}
