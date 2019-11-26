<?php

	$servername = "localhost";
	$dbusername = "root";  
	$dbpassword = "";  
	$databasename = "registration"; 
	
	// Create connection
	$conn = mysqli_connect($servername, $dbusername, $dbpassword, $databasename);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	echo "Connected successfully";