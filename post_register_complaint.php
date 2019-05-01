<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php


		date_default_timezone_set('Asia/Calcutta') ;


		$host="localhost";
		$dbusername="root";
		$dbpassword="password_fir";
		$dbname="Online_FIR";

		$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

		if($conn->connect_error)
		{
			die("connection failed: " . $conn->connect_error);
		}

		$assign_asi_row = "SELECT * FROM Users WHERE Designation='ASI' ORDER BY RAND() LIMIT 1" ;
		$assigned_asi_row = $conn->query($assign_asi_row) ; 

		if($assigned_asi_row->num_rows > 0)
		{
			$row = $assigned_asi_row->fetch_assoc() ; 
			$dor = date("Y/m/d") ; // Date of Registration // 
			$tor = date("H:i:s") ; // Time of Registration // 

			/* Fetching data from POST Request */
			$assigned_asi_username = $row['Username'] ;
			$name = $_POST['name'] ; 
			$age = $_POST['age'] ; 
			$address = $_POST['address'] ;
			$doi = $_POST['doi'] ; // Date of Incident //
			$toi = $_POST['toi'] ; // Time of Incident // 
			$complaint = $_POST['complaint'] ; 
			/* Fetching data from POST Request */

			$getSectionCategory_query = "SELECT * FROM Mapping WHERE Complaint='$complaint'" ;
			$getSectionCategory = $conn->query($getSectionCategory_query) ;
			$row = $getSectionCategory->fetch_assoc() ; // USER CAN MESS UP IF THERE ARE NO AVAILABLE COMPLAINTS // 
			$section = $row['Section'] ; 
			$category = $row['Category'] ;
			$status = "Assigned to ASI" ; 

			$insertComplain_query = "INSERT INTO `Complaints`(`Name`, `Age`, `Address`, `Date of Incidence`, `Time of Incidence`, `Date of Registration`, `Time of Registration`, `Complaint`, `Section`, `Category`, `Status`, `Assigned_ASI`) VALUES ('$name','$age','$address','$doi','$toi','$dor','$tor','$complaint','$section','$category','$status','$assigned_asi_username')" ; 
			$insertComplain = $conn->query($insertComplain_query) ; 
			echo "Complaint Registered Successfully" ; 
		}
		else
		{
			echo "ASI not available" ;
		}

		$conn->close() ;
	?>
</body>
</html>