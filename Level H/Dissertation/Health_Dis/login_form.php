<?php

session_start();

if (isset($_POST['username']))
{
	doAuthenticate();
}


function doAuthenticate()
{
    // login and use database
    $conn = mysqli_connect("localhost", "root", "Root#123", "health_database");

    // error check for dtabase connection
    if (!$conn)
    {
    	die("Connection Failed: " . mysqli_connect_error());
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/securimage/securimage.php';
    $securimage = new Securimage();

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
    $password = hash('sha512', $password);


	$sql = "SELECT username, password FROM authentication WHERE username = '$username' AND password= '$password' ";

	$result = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	$numOfRows = mysqli_num_rows($result);
    
    

	if ($numOfRows == 1 && $securimage->check($_POST['captcha_code']) == true)
	{
  
		$line = mysqli_fetch_array($result);
		$_SESSION['username'] = $line['username'];

        $find_user = $line['username'];
        $username_length = strlen($find_user);
        
        $char = str_split($find_user, 1);
        if ($char[4] == "h")
        {
		  header("location: hcp_welcome.php");
        }
        elseif ($char[4] == "p")
        {
          header("location: patient_welcome.php");
        }
	}

	if ($numOfRows != 1)
	{
		echo ("<h2>Login failed - authentication error</h2>");
	}	

    if ($securimage->check($_POST['captcha_code']) == false)
    {
        echo ("<h3>The security code entered was INCORRECT.<br></h3>");
        echo ("<h3>Please try again.</h3>");
    }   
  
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login_form_CSS.css">
    <style type="text/css">
        body{ font: 17px sans-serif; text-align: center; }
        .wrapper
        { 
            margin-left: auto;
            margin-right: auto;
            width: 380px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <img src="images/logo.png" alt="logo" width = "200" height = "135">
        <div class="form-title"><h1> Health Web Page Login</h1></div>
        <p>Please enter your username and password and click submit.</p>

        <form class="form-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete = "off">

            <div class="form-title">
                <label>Username:</label>
                <input type="text" name="username" class="form-field" value= "" required>
            </div>

            <div class="form-title">
                <label>Password (Case sensitive):</label>
                <input type="password" name="password" class="form-field" required>
            </div>

            <label>Please enter the characters seen in the image</label>
            <br>
            <img id="captcha" src="securimage/securimage_show.php" alt="CAPTCHA Image" />
            <input class="form-field" type="text" name="captcha_code" size="10" maxlength="6" required/>
            <a href="#" onclick="document.getElementById('captcha').src = 'securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
            <br>
            
            <div class="submit-container">
                <a href="http://phpcaptcha.org/" target="_blank"><img src="images/securimage.png" width = "100" height = "30" align ="left"></a>
                <input class="submit-button" type="submit" value="Submit" />
            </div>
        </form>

    </div>   
</body>
</html>