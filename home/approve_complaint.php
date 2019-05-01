<!DOCTYPE html>
<html>
<body>
    
<?php
// Initialize the session
session_start();
$msg = "Succefully Approved!" ;
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}

require_once "../config.php" ;


$sql = "UPDATE Complaints SET `Status` = 'Upgraded to FIR', `Assigned_SI` = ? WHERE `ID` = ?" ; 
$sql2 = "SELECT Username FROM `Users` WHERE `Designation` = 'SI' AND `Category` = ? ORDER BY RAND() LIMIT 1" ; 

$stmt2 = NULL ;
$assigned_si_username = "" ;
if($stmt2 = mysqli_prepare($link, $sql2))
{
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt2, "s", $param_category) ;
    $param_category = $_POST['category'];

    if(mysqli_stmt_execute($stmt2))
    {
        // Store result
        mysqli_stmt_store_result($stmt2);
        mysqli_stmt_bind_result($stmt2, $assigned_si_username_temp);
        if(mysqli_stmt_num_rows($stmt2) == 0)
        {
            $msg = "No SI available!" ;
            exit ;
        }
        if(mysqli_stmt_fetch($stmt2))
        {
            $assigned_si_username = $assigned_si_username_temp ;
        }
        else
        {
            $msg = "Oops! Something went wrong. Please try again later.";
            exit ;
        }
    } 
    else
    {
        $msg = "Oops! Something went wrong. Please try again later.";
        exit ; 
    }

}


if($stmt = mysqli_prepare($link, $sql))
{
    if($stmt2 != NULL)
    {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss",$assigned_si_username , $id) ;
        $id = $_POST['id'] ;

        if(mysqli_stmt_execute($stmt))
        {
            ;
        } 
        else
        {
            $msg = "Oops! Something went wrong. Please try again later.";
            exit ; 
        }
    }
    else
    {
        $msg = "No SI available!";
        exit ;
    }

}


?>
    <form id="f" method="post" action="view_complaints.php">
        <input type="hidden" value="<?php echo $msg ?>" name="msg">
    </form>
    <script>
        document.getElementById("f").submit() ;
    </script>
</body>
</html>