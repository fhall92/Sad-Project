<?php
require "header.php";
require "dbh.php";

if (!isset($_SESSION['id']) || $_SESSION['username'] != 'ADMIN') {
	header("Location: ../sadproject/main_page.php?error=UnauthorisedAccessAdminOnly");
}

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
	<div>
		<h1>
			<center>LOG</center>
		</h1>
	</div>
	<div>
		<table border="1">
			<tr>
				<th>Id</th>
				<th>Username</th>
				<th>IP</th>
				<th>Timestamp</th>
				<th>isSuccess</th>

			</tr>
			<?php

			// Check connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			}
			$sql = "SELECT `id`, `username`, `ip`, `timestamp`, `isSuccess` FROM `attempts`";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td>" . $row["id"] . "</td><td>". $row["username"]."</td><td>". $row["ip"]  . "</td><td>". $row["timestamp"]. "</td><td>". $row["isSuccess"]  ."</tr>";
				}
				echo "</table>";
			} else {
				echo "0 results";
			}
			$conn->close();
			?>
		</table>
	</div>

</body>

</html>