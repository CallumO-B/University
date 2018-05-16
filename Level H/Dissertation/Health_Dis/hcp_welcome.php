<?php

session_start();

if(!isset($_SESSION['username']) || empty($_SESSION['username']))
{
    header("location: login_form.php");
    exit;
}

$conn = mysqli_connect("localhost", "healthCareProfessional", "hcpHOPEuniversity#2018", "health_database");

if (!$conn)
{
    die("Connection Failed: " . mysqli_connect_error());
}

// get an array of logs to display as a table on welcome page 
$get_patients = "SELECT uID FROM patient"; // change to UID
$patients = mysqli_query($conn, $get_patients) or die(mysqli_error());

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
        #patients
        {
            border-collapse: collapse;
            width: 50%;
        }

        #patients th, #patients td 
        {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }
        #patients th
        {
            background-color:#20a354;
            color: black;
        }

        #patients tr:nth-child(even) {background-color: #e1e1e1;}
        #patients tr:hover {background-color:#f1f1f1;}

        div.patient_table
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
            <h1>Welcome <b><?php echo $_SESSION['username']; ?></b></h1>
        </div>
        
        <div>
            <a href="logout.php" class="button">Log Out of Your Account</a>
        </div>

        <div class = patient_table style = "overflow-y: auto;">
            <form action = "patient_hcp_log.php" method = "post" >

                <input type="text" id="input" onkeyup="searchPatientTable()" placeholder="Search for patient ..." title="Type in a patient ID">

                <table id = "patients"> 
                    <th> Select </th> <th> Patient </th>
                    <?php
                        while ($lines = mysqli_fetch_array($patients))
                        {
                            echo ("<tr><td><input type='radio' name='patient' value=".$lines['uID']." required></td>");
                            echo ("<td>" . $lines['uID']. "</td></tr>");
                        }
                    ?>
                </table>
                <br>   
                    <input type = "submit" class = "button" value = "Click To View Chosen Log" style= "float:left">
                </br>
            </form>
        </div>
        <script>
            function searchPatientTable() 
            {
                var input, filter, table, tr, td, i;
                input = document.getElementById("input");
                filter = input.value.toUpperCase();
                table = document.getElementById("patients");
                tr = table.getElementsByTagName("tr");

                for (i = 0; i < tr.length; i++) 
                {
                    td = tr[i].getElementsByTagName("td")[0];
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