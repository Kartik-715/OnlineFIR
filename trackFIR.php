<?php

$numError = "" ; 
$firNumber = 0 ; 

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty(trim($_POST['firNumber'])))
	{
		$numError = "Please Enter a FIR Number" ; 
	}
	else
	{
		if(intval($_POST['firNumber']) != 0)
		{
			$intFIR = intval($_POST['firNumber']) ; 
			// $firNumber = $intFIR ^ 0xDEADBEEF ; 
			$firNumber = $intFIR ; 
		}
		else
		{
			$numError = "The FIR number is not valid" ; 
		}
	}

	// Include config file
	require_once "config.php";



	$sql = "SELECT `Status` FROM `Complaints` WHERE `ID` = ?" ; 


	if($stmt = mysqli_prepare($link, $sql))
	{
	    // Bind variables to the prepared statement as parameters
	    mysqli_stmt_bind_param($stmt, "i", $param_id) ;
	    $param_id = $firNumber  ; 

	    if(mysqli_stmt_execute($stmt))
	    {
	        mysqli_stmt_store_result($stmt);

	        if(mysqli_stmt_num_rows($stmt) != 0)
	        {                    
	            // Bind result variables
	            mysqli_stmt_bind_result($stmt, $status);


	            if(mysqli_stmt_fetch($stmt))
	            {
	            }
	            else
	            {
	            	echo "Error Occured" ; 
	            	exit ; 
	            }

	        }
	        else
	        {
	        	$numError = "No Record in DB Found" ; 
	        }

	    
	    } 
	    else
	    {
	        echo "Oops! Something went wrong. Please try again later.";
	        exit ; 
	    }


	}





}



?>


<!DOCTYPE html>
<html>
<head>
	<title>FIR</title>
</head>
<body>
	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($numError)) ? 'has-error' : ''; ?>">
                <label>Fir Number: </label>
                <input type="text" name="firNumber" class="form-control" value="<?php echo $firNumber; ?>">
                <span class="help-block"><?php echo $numError; ?></span>
            </div> 
    </form>

    <br>

    <?php
    	if(!empty($status))
    	{
    		echo "<label> ".$status." </label>" ;
    	}
    ?>

    <form method="post" action="fir.php">
    	
    </form>





<div style="margin:5% 30% 0 30%; padding:10px; border-color: teal; border-style: dashed;">
	<center style="font-size: 22px"><b>F</b>irst <b>I</b>nvestigation <b>R</b>eport</center>
	<hr style="border-top: dashed 1px;">
	<div style="float: right;">No:</div>
	<br>
	<div>
		Name:<br>
		Age:<br>
		Address:<br>
		Complaint:<br>
		Section:<br>
		<br><br><br><br><br><br>
		Date of Incidence:<div style="float: right;">Time: </div><br>
		Date of Registration:<div style="float: right;">Time: </div>
	</div>
</div>


</body>
</html>