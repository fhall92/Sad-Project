<?php
require "header.php";
include "sanitise_function.php";

unset($_SESSION['attemptName']);

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
	$username = Sanitise($username);

	if (($currentTime - $_SESSION['lockoutTime']) < 180 && $_SESSION['lockout'] == true) {
		header("Location: login.php?error=LockedOut");
	} else {
		$_SESSION['lockout'] = false;
		//Check for empty forms **POSSIBLE USELESS MIGHT DELETE LATER IDK**
		if (empty($username) || empty($password)) {
			header("Location: login.php?error=emptyfields");
			exit();
		} else {
			$sql = "SELECT * FROM users WHERE username=?";

			if (!mysqli_stmt_prepare($stmt, $sql)) {
				header("Location: login.php?error=sqlerror1");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				//If $result holds a value
				if ($row = mysqli_fetch_assoc($result)) {

					//If Passwords don't match
					$salt = $row['salt'];

					$saltedPassword = $salt . $password;
					$passwordHash = Md5($saltedPassword);

					//header("Location: home.php?$salt");

					if ($passwordHash == $row['password']) {
						$passwordCheck = true;
					} else {
						$passwordCheck = false;
					}

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
										AND `isSuccess` LIKE 0
										AND `timestamp` > DATE_SUB(NOW(), INTERVAL 3 MINUTE);");
						$_SESSION['count'] = mysqli_fetch_array($result, MYSQLI_NUM);

						//IF over 5 attempts
						if ($_SESSION['count'][0] > 5) {
							//User is locked out, set Lockout to true and record lockout time
							$_SESSION['lockout'] = true;
							$_SESSION['lockoutTime'] = time();

							header("Location: login.php?error=LockedOut");

						}

						//Else, if user is not Locked out
						else {
							if ($_SESSION['count'][0] != 5) {
								$attemptsRemaining = (5 - $_SESSION['count'][0]);
							}
						}

						$_SESSION['attemptName'] = $username;
						header("Location: login.php?error=InvalidLogin");
					} else {
						//Create Session
						session_start();
						$_SESSION['id'] = $row['id'];
						$_SESSION['username'] = $row['username'];
						$loginSuccess = 1;

						//Store Successful Login Attempts
						$sql = "INSERT INTO `attempts`(`username`, `ip`, `userAgent`,`isSuccess`) VALUES (?,?,?,?)";
						if (mysqli_stmt_prepare($stmt, $sql)) {
							mysqli_stmt_bind_param($stmt, "ssss", $username, $ip, $userAgent, $loginSuccess);
							mysqli_stmt_execute($stmt);
						}

						header("Location: main_page.php?login=success");
					}
				} else {

					//Store unsuccessful Login Attempts
					$sql = "INSERT INTO `attempts`(`username`, `ip`, `userAgent`) VALUES (?,?,?)";
					if (mysqli_stmt_prepare($stmt, $sql)) {
						mysqli_stmt_bind_param($stmt, "sss", $username, $ip, $userAgent);
						mysqli_stmt_execute($stmt);
					}

					$result = mysqli_query($conn, "SELECT COUNT(*) FROM `attempts` WHERE 
										`ip` LIKE '$ip' 
									AND `userAgent` LIKE '$userAgent'
									AND `isSuccess` LIKE 0
									AND `timestamp` > DATE_SUB(NOW(), INTERVAL 3 MINUTE);");
					$_SESSION['count'] = mysqli_fetch_array($result, MYSQLI_NUM);

					//IF over 5 attempts
					if ($_SESSION['count'][0] > 5) {
						//User is locked out, set Lockout to true and record lockout time
						$_SESSION['lockout'] = true;
						$_SESSION['lockoutTime'] = time();

						$_SESSION['attemptName'] = $username;
						header("Location: login.php?error=InvalidLogin");
					}

					//Else, if user is not Locked out
					else {
						if ($_SESSION['count'][0] != 5) {
							$attemptsRemaining = (5 - $_SESSION['count'][0]);
						}
					}

					$_SESSION['attemptName'] = $username;
						header("Location: login.php?error=InvalidLogin");
				}
			}
		}
	}
}

//If user has accessed page without clicking submit on login.php
else {
	header("Location: login.php?error=UnauthorisedAccess");
	exit();
}
