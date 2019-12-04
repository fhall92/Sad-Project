<?php 
    session_start();
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
    $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
?>