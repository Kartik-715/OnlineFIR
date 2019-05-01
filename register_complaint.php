<!DOCTYPE html>
<html>
<head>
	<title>Register Complaint</title>
</head>
<body>
	<form method="post" action="post_register_complaint.php">
		Name : <input type=text name=name><br>
		Age : <input type=text name=age><br>
		Address : <input type=text name=address><br>
		Date Of Incident : <input type=date name=doi value="2000-01-01"><br>
		Time Of Incident : <input type=time name=toi value="00:00"><br>
		Complaint :
		<select name=complaint>
			<option value="Attempt to Murder">Attempt to Murder</option>
			<option value="Theft">Theft</option>
		</select>
		<input type=submit>
	</form>
</body>
</html>