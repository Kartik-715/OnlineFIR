<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php
		$host="localhost";
		$dbusername="root";
		$dbpassword="password_fir";
		$dbname="Online_FIR";

		$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
		if($conn->connect_error){
			die("connection failed: " . $conn->connect_error);
		}
		else{
			echo "Connected Successfully";
		}

		$assign_asi_row = "SELECT * FROM Users WHERE Designation='ASI'" ;
		$assigned_asi_row = $conn->query($assign_asi_row) ;

		if($assigned_asi_row->num_rows > 0){
			while($row = $assigned_asi_row->fetch_assoc()){
				$assigned_asi_username = $row['Username'] ;
			}

		}
		else{
			echo "ASI not present." ;
		}

		$conn->close() ;
	?>
</body>
</html>