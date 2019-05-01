<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: /login.php");
    exit;
}

require_once "../config.php" ;

$sql = "SELECT `ID`, `Name`, `Age`, `Address`, `Date of Incidence`, `Time of Incidence`, `Date of Registration`, `Time of Registration`, `Complaint`, `Section`, `Category`, `Status`, `Assigned_SI` FROM `Complaints` WHERE `Assigned_ASI` = ?" ; 


if($stmt = mysqli_prepare($link, $sql))
{
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username) ;
    $param_username = $_SESSION['username'] ; 

    if(mysqli_stmt_execute($stmt))
    {
        // Store result
        mysqli_stmt_store_result($stmt);
        
        // Check if username exists, if yes then verify password
    } 
    else
    {
        echo "Oops! Something went wrong. Please try again later.";
        exit ; 
    }


}



?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        th,td{ padding: 2px ;}
    </style>
</head>
<body>
    <center>
        <h1>List of All the Complaints</h1>
        <?php 
        if(mysqli_stmt_num_rows($stmt) != 0)
        {                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $name, $age, $address, $doi, $toi, $dor, $tor, $complaint, $section, $category, $status, $assigned_si );


            while(mysqli_stmt_fetch($stmt))
            {
                /* Have Access to all the complaints now */
                // echo('<div> Name: '.$name.' <br> Date of Incident: '.$doi.' <br> </div>') ; 

                //echo "$id $name $age $address $doi $toi $dor $tor $complaint $section $category $status $assigned_si" ; 

                echo('<table style="border: 2px solid teal; width: 15%;padding-left: 10px;">
                        <tbody align="left" >
                        <tr> <th>Name: </th> <td>'.$name.'</td> </tr>    
                        <tr> <th>Age: </th> <td>'.$age.'</td> </tr>  
                        <tr> <th>Address: </th> <td>'.$address.'</td> </tr>
                        <tr> <th>Date of Incident: </th> <td>'.$doi.'</td> </tr>
                        <tr> <th>Time of Incident: </th> <td>'.$toi.'</td> </tr>
                        <tr> <th>Date of Registration: </th> <td>'.$dor.'</td> </tr>
                        <tr> <th>Time of Registration: </th> <td>'.$tor.'</td> </tr>
                        <tr> <th>Complaint: </th> <td>'.$complaint.'</td> </tr>
                        <tr> <th>Category: </th> <td>'.$category.'</td> </tr>
                        <tr> <th>Status: </th> <td>'.$status.'</td>  </tr>
                        </tbody>
                        <br> 
                                    
                        ') ; 
            }


        } 
        else
        {
            echo "<h3> No Complaints to Show <h3> " ;
            exit ;  
        }


     ?>


    </center>
    
</body>
</html>