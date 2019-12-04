<?php
require "header.php";

//Ensure user accessed page by clicking submit button on login.php
if (isset($_POST['login-submit'])) {

	if (!isset($_SESSION['lockout']) && !isset($_SESSION['lockoutTime'])) {
		$_SESSION['lockout'] = false;
		$_SESSION['lockoutTime'] = 0;
	}

	require 'dbh.php';
	$username = $_POST['username'];
	$password = $_POST['password'];
	$ip = $_SERVER['REMOTE_ADDR'] ?: ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['HTTP_CLIENT_IP']);
	$userAgent = $_SERVER['HTTP_USER_AGENT'];
	$stmt = mysqli_stmt_init($conn);
	$currentTime = time();

	if (($currentTime - $_SESSION['lockoutTime']) < 180 && $_SESSION['lockout'] == true) {
		echo "<script>
						alert ('You are within Lockout timeframe. Please try again later.');
								window.location.href = 'login.php?error=LockedOut';
								</script>";
	} else {
		$_SESSION['lockout'] = false;
		//Check for empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
		if (empty($username) || empty($password)) {
			header("Location: ../sadproject/login.php?error=emptyfields");
			exit();
		} else {
			$sql = "SELECT * FROM users WHERE username=?";

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
						$sql = "INSERT INTO `attempts`(`username`, `ip`, `userAgent`) VALUES (?,?,?)";
						if (mysqli_stmt_prepare($stmt, $sql)) {
							mysqli_stmt_bind_param($stmt, "sss", $username, $ip, $userAgent);
							mysqli_stmt_execute($stmt);
						}

						$result = mysqli_query($conn, "SELECT COUNT(*) FROM `attempts` WHERE 
											`ip` LIKE '$ip' 
                                        AND `userAgent` LIKE '$userAgent'
										AND `isSucess` LIKE 0
										AND `timestamp` > DATE_SUB(NOW(), INTERVAL 3 MINUTE);");
						$_SESSION['count'] = mysqli_fetch_array($result, MYSQLI_NUM);

						//IF over 5 attempts
						if ($_SESSION['count'][0] > 5) {
							//User is locked out, set Lockout to true and record lockout time
							$_SESSION['lockout'] = true;
							$_SESSION['lockoutTime'] = time();

							echo "<script>
						alert ('You are locked out.');
								window.location.href = 'login.php?error=LockedOut';
								</script>";
						}

						//Else, if user is not Locked out
						else {
							if ($_SESSION['count'][0] != 5) {
								echo "you have " . (5 - $_SESSION['count'][0]) . " attempts remaining";
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
				} else {
					echo "<script>
						alert ('The username ' + '$username' + 
								' and password combination cannot be authorised');
								//window.location.href = 'login.php';
								</script>";
				}
			}
		}
	}
}

//If user has accessed page without clicking submit on login.php
else {
	header("Location: ../sadproject/login.php?error=UnauthorisedAccess");
	exit();
}
