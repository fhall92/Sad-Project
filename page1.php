<?php 

    require 'header.php';

    echo 'Page 1\n';
    echo $_SESSION['id'];
    echo $_SESSION['username'];

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
        </body>
    </html>
