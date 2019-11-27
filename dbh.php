<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$databasename = "registration"; 

$conn = new mysqli ($servername,$dbusername,$dbpassword);

//Checking Connection
if ($conn->connect_error){
 echo "Connection not detected".$conn->connect_error;
}

//Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS registration";
if ($conn->query($sql) === FALSE){
return true;
}

mysqli_select_db($conn, $databasename);

$table_sql = "CREATE TABLE IF NOT EXISTS users (
	`id` int(11) NOT NULL auto_increment,         
	`username` varchar(30)  NOT NULL default '',    
	`password` varchar(256)  NOT NULL default '', 
	 PRIMARY KEY  (`id`)
  )"; 

if ($conn->query($table_sql) === FALSE){
echo "Table not created: ".$conn->error;
}














echo "Connected Successfully";