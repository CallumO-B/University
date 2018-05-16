<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: hcp_welcome.php");
    exit;
}

$conn = mysqli_connect("localhost", "healthCareProfessional", "hcpHOPEuniversity#2018", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

if(isset($_POST) && 0 === count($_POST))
{
    echo ("<h1>Check Box was NOT Selected</h1><p><h2>Please go back and try again</h2></p>");
}

$chosen_patient = $_POST["patient"];
// get an array of logs to display as a tbale on welcome page 
$get_patientLog = "SELECT * FROM patient_log WHERE uID = $chosen_patient";
$patient_logs = mysqli_query($conn, $get_patientLog) or die(mysqli_error());
$numOfRows = mysqli_num_rows($patient_logs);

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Welcome</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="welcome_form_CSS.css">

    <script type="text/javascript" src = "javascript_library/chart_bundle.js"></script>

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

        #logs 
        {
            border-collapse: collapse;
            width: 50%;
        }

        #logs th, #logs td 
        {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        #logs th
        {
            background-color:#20a354;
            color: black;
        }

        #logs tr:nth-child(even) {background-color: #e1e1e1;}
        #logs tr:hover {background-color:#f1f1f1;}

        div.log_table
        {
            position: relative;
            left: 60px;
            bottom: -50px;
        }

    </style>

</head>
    <body>

        <div class="page-header">
            <img src="javascript_library/logo.png" alt="logo" width = "200" height = "135">
            <h1>Logs for patient: <b><?php echo $chosen_patient; ?></b></h1>
            
        </div>
        
        <div>
            <a href="hcp_welcome.php" class="button">Go Back</a>
        </div>

        <div class = log_table style = "overflow-y: auto;">
            <form action = "graphical_data.php" method = "post">

                    
                        <?php
                            if($numOfRows >0)
                            {
                                echo("<table id = 'logs'> ");
                                echo("<th> Select </th><th> Log </th> <th> Date </th>");
                            
                                while ($lines = mysqli_fetch_array($patient_logs))
                                {
                                    echo ("<tr><td><input type='radio' name='logID' value=".$lines['logID']." required></td>");
                                    echo ("<td>" . $lines['logID']. "</td> ");
                                    echo ("<td>" . $lines['dateValue']. "</td></tr>"); 
                                }
                                echo(" </table>
                                    <br>   
                                      <input type = 'submit' class = 'button' value = 'Click To View Chosen Log' style= 'float:left'>
                                    </br>");
                            }

                            elseif ($numOfRows == 0)
                            {?>
                                <h1><b>No Patient Logs Found for selected patient</b></h1>
                            <?php 
                                }
                            ?>

                    
            </form>
        </div>
    </body>
</html>