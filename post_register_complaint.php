<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<?php


		date_default_timezone_set('Asia/Calcutta') ;


		// Include config file
		require_once "config.php";

		$assign_asi_row = "SELECT * FROM Users WHERE Designation='ASI' ORDER BY RAND() LIMIT 1" ;
		$assigned_asi_row = $link->query($assign_asi_row) ; 

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
			$getSectionCategory = $link->query($getSectionCategory_query) ;
			$row = $getSectionCategory->fetch_assoc() ; // USER CAN MESS UP IF THERE ARE NO AVAILABLE COMPLAINTS // 
			$section = $row['Section'] ; 
			$category = $row['Category'] ;
			$status = "Assigned to ASI" ; 

			$id_temp = uniqid() ;
			$insertComplain_query = "INSERT INTO `Complaints`(`ID`,`Name`, `Age`, `Address`, `Date of Incidence`, `Time of Incidence`, `Date of Registration`, `Time of Registration`, `Complaint`, `Section`, `Category`, `Status`, `Assigned_ASI`) VALUES ('$id_temp','$name','$age','$address','$doi','$toi','$dor','$tor','$complaint','$section','$category','$status','$assigned_asi_username')" ; 
			$insertComplain = $link->query($insertComplain_query) ; 
			echo "Complaint Registered Successfully<br>" ;
			echo "Please note your FIR number: ".$id_temp ;
		}
		else
		{
			echo "ASI not available" ;
		}

		$link->close() ;
	?>
</body>
</html>