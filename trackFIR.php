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



	$sql = "SELECT `ID`, `Name`, `Age`, `Address`, `Date of Incidence`, `Time of Incidence`, `Date of Registration`, `Time of Registration`, `Complaint`, `Section`, `Category`, `Status`, `Assigned_SI` FROM `Complaints` WHERE `ID` = ?" ; 


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
	            mysqli_stmt_bind_result($stmt, $id, $name, $age, $address, $doi, $toi, $dor, $tor, $complaint, $section, $category, $status, $assigned_si);


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
    		echo "<label> FIR Status: ".$status." </label>" ; 
    	}
    ?>

    <br> <br>
    <br> <br>



    <form method="post" action="fir.php">
    	<input type="hidden" name="id" value="<?php echo $id ?>">
    	<input type="hidden" name="name" value="<?php echo $name ?>">
    	<input type="hidden" name="age" value="<?php echo $age ?>">
    	<input type="hidden" name="address" value="<?php echo $address ?>">
    	<input type="hidden" name="doi" value="<?php echo $doi ?>">
    	<input type="hidden" name="toi" value="<?php echo $toi ?>">
    	<input type="hidden" name="dor" value="<?php echo $dor ?>">
    	<input type="hidden" name="tor" value="<?php echo $tor ?>">
    	<input type="hidden" name="complaint" value="<?php echo $complaint ?>">
    	<input type="hidden" name="section" value="<?php echo $section ?>">
    	<input type="hidden" name="category" value="<?php echo $category ?>">
    	<input type="hidden" name="status" value="<?php echo $status ?>">
    	<?php 
    			if(!empty($id) && $status !== "Assigned to ASI")
    			{
    				echo '<button type="submit">Download FIR</button>' ; 
    			}
    	?>
    	
    </form>
</body>
</html>