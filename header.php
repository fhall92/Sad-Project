<?php 
    session_start();
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];

    
	if (!isset($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time();
    }

$_SESSION['currentTime'] = time();
$maxSessionTime = 3600;

if(($_SESSION['currentTime'] - $_SESSION['startTime']) >= $maxSessionTime){
    session_unset();
    session_destroy();
    header("Location: ../sadproject/home.php?SessionTimeout");
    exit();
}
?>