<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: login_form.php");
    exit;
}

$conn = mysqli_connect("localhost", "root", "Root#123", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) 
{

    $target_directory = "uploads/";
    $target_file = $target_directory . basename($_FILES['csv']['name']);
    $uploadOk = 1;
    $datalog_fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) 
    {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($datalog_fileType != "txt" && $datalog_fileType != "csv") 
    {
        echo "Sorry, only txt and csv files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } 

    else 
    {
        if (move_uploaded_file($_FILES["csv"]["tmp_name"], $target_file)) 
        {
            echo ("<h3>The file ". basename( $_FILES["csv"]["name"]). " has been uploaded.</h3>");
        } 
        else 
        {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $handle = fopen($target_file,"r"); 
    $line = fgetcsv($handle,","); 
    // required to prevent first line of data log file from being uploaded as this data is only for use by the health monitor itself. 
    $date = "";
    for ($i = 0; $i<1; $i++)
            {
                $line = fgetcsv($handle,",");
                if($line [$i] == "")
                {}
                else
                {
                    $date = $line [$i];
                }
            }
    $user = $_SESSION['username'];

    $get_patientUID= "SELECT uID FROM patient_authentication WHERE username = '$user'";
    $get_uID = mysqli_query($conn, $get_patientUID)or die(mysqli_error());
    $uID = mysqli_fetch_array($get_uID);
    $patientUID = $uID [0];

    mysqli_query($conn, "INSERT INTO patient_log (dateValue, uID) VALUES ('$date', '$patientUID')") or die(mysqli_error());


    $get_datalogID = "SELECT logID FROM patient_log WHERE uID = '$patientUID' AND dateValue ='$date'";
    $get_logID = mysqli_query($conn, $get_datalogID)or die(mysqli_error());
    $logID = mysqli_fetch_array($get_logID);
    $patient_logID = $logID [0];

    mysqli_free_result($get_uID);
    mysqli_free_result($get_logID);

    do { 
        $timeValue = $line [1];
        $temperature = $line [2];
        $emg = $line [3];
        $ecg = $line [4];
        $airFlow = $line [5];
        $skinConductance = $line [6];
        $skinResistance = $line [7];
        $skinConductanceVoltage = $line [8];
        $beatsPerMinute = $line [9];
        $bloodOxygen = $line [10];
        $query = "INSERT INTO monitor_data (logID, timeValue, temperature, emg, ecg, airFlow, skinConductance, skinResistance, skinConductanceVoltage, beatsPerMinute, bloodOxygen) 
            VALUES 
                ('$patient_logID','$timeValue','$temperature','$emg','$ecg','$airFlow','$skinConductance', '$skinResistance', '$skinConductanceVoltage', '$beatsPerMinute', '$bloodOxygen')";
        mysqli_query($conn, $query) or die(mysqli_error()); 

        } while ($line = fgetcsv($handle,",")); 
    fclose($handle);
    unlink($target_file);
}
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
    </style>

</head>
    <body>

        <div class="page-header">
            <img src="images/logo.png" alt="logo" width = "200" height = "135">
            <h1><b>Upload Page</b></h1>  <br>
            <p> 
                <a href="patient_welcome.php" class="button">Go Back to Welcome Page</a>  
            </p>          
        </div>
       
        <div>
            <h3><p>
                Select data log file to upload
            </p></h3>     
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" class="button" name="csv" id="csv" required><br><br>
            <input type="submit"  class="button" value="Upload Data Log" name="submit">
        </form>
    </body>
</html>