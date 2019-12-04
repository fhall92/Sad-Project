<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$databasename = "registration";

$conn = new mysqli($servername, $dbusername, $dbpassword);

//Checking Connection
if ($conn->connect_error) {
	echo "Connection not detected" . $conn->connect_error;
}

//Create databases if it none exist
$sql = "CREATE DATABASE IF NOT EXISTS registration";
if ($conn->query($sql) === FALSE) {
	return true;
}

mysqli_select_db($conn, $databasename);

$table_sql = "CREATE TABLE IF NOT EXISTS users (
	`id` int(11) NOT NULL auto_increment,         
	`username` varchar(30)  NOT NULL default '',    
	`password` varchar(256)  NOT NULL default '', 

	 PRIMARY KEY  (`id`)
  )";

if ($conn->query($table_sql) === FALSE) {
	echo "Table 1 not created: " . $conn->error;
}


$table_sql = "CREATE TABLE IF NOT EXISTS attempts(
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`username` VARCHAR(30) NOT NULL,
	`ip` CHAR(16) COLLATE utf8_bin NOT NULL,
	`userAgent` VARCHAR(256) NOT NULL,
	`isSuccess` INT NOT NULL DEFAULT (0),
	`timestamp` timestamp NOT NULL DEFAULT NOW());";

if ($conn->query($table_sql) === FALSE) {
	echo "Table 2 not created: " . $conn->error;
}
