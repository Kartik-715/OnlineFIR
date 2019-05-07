<!DOCTYPE html>
<html>
<head>
	<title>Register Complaint</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
</head>
<body>
	<center><h3>Register your complaints here!</h3></center>
	<hr>
	<br>
	<center>
		<div style="width: 30%;">
			<form method="post" action="post_register_complaint.php">
				<div  style="float: left;">Name : </div><input style="float: right;" type=text name=name><br>
				<div  style="float: left;">Age :</div> <input style="float: right;" type=text name=age><br>
				<div  style="float: left;">Address :</div> <input style="float: right;" type=text name=address><br>
				<div  style="float: left;">Date Of Incident :</div> <input style="float: right;" type=date name=doi value="2000-01-01"><br>
				<div  style="float: left;">Time Of Incident :</div> <input style="float: right;" type=time name=toi value="00:00"><br>
				<div  style="float: left;">Complaint :</div>
				<select name=complaint style="float: right;">
					<option value="Attempt to Murder">Attempt to Murder</option>
					<option value="Theft">Theft</option>
				</select>
				<br>
				<input type=submit>
			</form>
		</div>
	</center>
</body>
</html>