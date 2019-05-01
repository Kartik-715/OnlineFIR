<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

require_once "../config.php" ;

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        tr,th,td{ padding-left: 5px ; margin-left: 5px ;}
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <center>
        <h1>List of All the Complaints</h1>
        <?php 

            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                if($_POST["act"]=="Approve")
                {
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
                                echo "No SI available!<br>" ;
                                goto lbl;
                            }
                            if(mysqli_stmt_fetch($stmt2))
                            {
                                $assigned_si_username = $assigned_si_username_temp ;
                            }
                            else
                            {
                                echo "Oops! Something went wrong. Please try again later.<br>";
                                goto lbl;
                            }
                        } 
                        else
                        {
                            echo "Oops! Something went wrong. Please try again later.<br>";
                            goto lbl;
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
                                $msg = "Oops! Something went wrong. Please try again later.<br>";
                                goto lbl;
                            }
                        }
                        else
                        {
                            echo "No SI available!<br>";
                            goto lbl;
                        }
                    }

                    echo "Successfully Approved<br>" ;
                }
                else if($_POST["act"]=="Decline")
                {
                    $sql3 = "DELETE FROM `Complaints` WHERE ID=".$_POST['id'] ;
                    if($stmt2 = mysqli_prepare($link, $sql3))
                    {
                        // Bind variables to the prepared statement as parameters

                        if(mysqli_stmt_execute($stmt2))
                        {
                            ;
                        } 
                        else
                        {
                            echo "Oops! Something went wrong. Please try again later.<br>";
                            goto lbl;
                        }

                    }
                }
            }

            lbl:

            $sql = "SELECT `ID`, `Name`, `Age`, `Address`, `Date of Incidence`, `Time of Incidence`, `Date of Registration`, `Time of Registration`, `Complaint`, `Section`, `Category`, `Status`, `Assigned_SI` FROM `Complaints` WHERE `Status`= 'Assigned to ASI' AND `Assigned_ASI` = ?" ; 


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




            if(mysqli_stmt_num_rows($stmt) != 0)
            {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $name, $age, $address, $doi, $toi, $dor, $tor, $complaint, $section, $category, $status, $assigned_si);


                while(mysqli_stmt_fetch($stmt))
                {
                    /* Have Access to all the complaints now */
                    // echo('<div> Name: '.$name.' <br> Date of Incident: '.$doi.' <br> </div>') ; 

                    //echo "$id $name $age $address $doi $toi $dor $tor $complaint $section $category $status $assigned_si" ; 

                    echo('<table style="border: 2px solid teal; width: 25%;">
                            <tbody>
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
                            </table>
                            <form method="post" action="view_complaints.php">
                                <input type="hidden" name="id" value="'.$id.'">
                                <input type="hidden" name="act" value="Approve">
                                <input type="hidden" name="category" value="'.$category.'">
                                <button type=submit>Approve</button>
                            </form>
                            <form method="post" action="view_complaints.php">
                                <input type="hidden" name="id" value="'.$id.'">
                                <input type="hidden" name="act" value="Decline">
                                <button type=submit>Decline</button>
                            </form>
                            <br>'
                    ) ; 
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