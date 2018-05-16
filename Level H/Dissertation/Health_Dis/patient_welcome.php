<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: login_form.php");
    exit;
}

$conn = mysqli_connect("localhost", "patient", "patientHOPEuniversity#2018", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

// get an array of logs to display as a tbale on welcome page 

$user = $_SESSION['username'];

// getting patient name to display on welcome page


$get_patientUID = "SELECT uID FROM patient_authentication WHERE username = '$user'";

$patientUID = mysqli_query($conn, $get_patientUID) or die(mysqli_error());
$line = mysqli_fetch_array($patientUID);

$get_patientLog = "SELECT * FROM patient_log WHERE uID = $line[uID]";
$patient_logs = mysqli_query($conn, $get_patientLog) or die(mysqli_error());

$get_patientName= "SELECT forename FROM patient WHERE uID = $line[uID]";
$patientNames = mysqli_query($conn, $get_patientName) or die(mysqli_error());
$patientName = mysqli_fetch_array($patientNames);

mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Welcome</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="welcome_form_CSS.css">


    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

        #input 
        {
          width: 50%;
          font-size: 16px;
          padding: 15px 10px 15px 10px;
          border: 2px solid #ddd;
          margin-bottom: 12px;
          position: relative;
        }
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
            <img src="images/logo.png" alt="logo" width = "200" height = "135">
            <h1>Welcome <b><?php echo $patientName['forename']; ?></b></h1>
            <br>
            <p>
                <a href="logout.php" class="button">Log Out of Your Account</a>
            </p>
        </div>
       
        <div>
                <a href="surgery.php" class="button">Surgery Contact Details</a>
                <a href="upload.php" class="button">Upload a data log</a>
                
        </div>

        <div class = log_table style = "overflow-y: auto;">
            <form action = "graphical_data.php" method = "post">
                <input type="text" id="input" onkeyup="searchLogTable()" placeholder="Search for log by (DD), (MM) or (YYYY)" title="Type in a date">
                    <table id = "logs"> 
                             <th> Select </th><th> Log </th> <th> Date </th>
                            <?php
                                while ($lines = mysqli_fetch_array($patient_logs))
                                {
                                    echo ("<tr><td><input type='radio' name='logID' value=".$lines['logID']." required></td>");
                                    echo ("<td>" . $lines['logID']. "</td> ");
                                    echo ("<td>" . $lines['dateValue']. "</td></tr>"); 
                                }
                            ?>

                    </table>
                    <br>   
                        <input type = "submit" class = "button" value = "Click To View Chosen Log" style= "float:left">
                    </br>
            </form>
        </div>
        <script>
            function searchLogTable() 
            {
                var input, filter, table, tr, td, i;
                input = document.getElementById("input");
                filter = input.value.toUpperCase();
                table = document.getElementById("logs");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) 
                {
                    td = tr[i].getElementsByTagName("td")[2];
                    if (td) 
                    {
                        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) 
                        {
                            tr[i].style.display = "";
                        } else 
                        {
                            tr[i].style.display = "none";
                        }
                    }       
                }
            }
        </script>
    </body>
</html>