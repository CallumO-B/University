<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: patient_welcome.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "Root#123", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

// get an array of logs to display as a tbale on welcome page 
$get_surgeryDetails = "SELECT * FROM surgery";
$surgeryDetails = mysqli_query($conn, $get_surgeryDetails) or die(mysqli_error());
?>



<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <title>Welcome</title>

    <link rel="stylesheet" type="text/css" href="welcome_form_CSS.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> 

    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }

        #surgery
        {
            border-collapse: collapse;
            width: 50%;
        }

        #surgery th, #surgery td 
        {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        #surgery th
        {
            background-color:#20a354;
            color: black;
        }

        #surgery tr:nth-child(even) {background-color: #e1e1e1;}

        div.surgery_table
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
            <h1><b></b> Surgery Details </h1>
            <p><a href="patient_welcome.php" class="button">Go Back</a></p>
        </div>
        
        <div class = surgery_table>
            <table id = "surgery"> 
                    <th> Surgery </th> <th> ContactNumber </th> <th> Address </th>
                    <?php
                        while ($lines = mysqli_fetch_array($surgeryDetails))
                        {
                            echo ("<tr><td>" . $lines['name'] . "</td>");
                            echo ("<td>" . $lines['contactNumber']. "</td>"); 
                            echo ("<td>" . $lines['addressL1'] ." ".$lines['addressL2'] ."   ". $lines['postcode'] ."   ". "</td></tr>");
                        }
                    ?>
            </table>
        </div>
    </body>
</html>