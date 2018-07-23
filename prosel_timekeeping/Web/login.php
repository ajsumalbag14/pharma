<?php
session_start();
// include database and object files
include_once 'classes/database.php';
include_once 'classes/users.php';
include_once 'initial.php';

if(!isset($message))
	$message = "";

//logout
if(isset($_GET["method"]) && $_GET["method"] == "logout") {
	session_destroy(); // will delete ALL data associated with that user.
	$message = "You have successfully logged out";
}

if(isset($_POST["username"]) && isset($_POST["password"])) 
{
	// instantiate database and user object
	$user = new Users($db);
	$user->username = htmlentities(trim($_POST["username"]));
	$user->password = htmlentities(trim($_POST["password"]));

	// select all users
	$result = $user->login();

	if($result <> null)
	{
		//set the sessions in here
		$_SESSION["USER_ID"] = $result["USER_ID"];
		$_SESSION["NAME"] = $result["FIRST_NAME"] . " " . $result["LAST_NAME"];
		$_SESSION["USER_TYPE"] = $result["USER_TYPE"];
		
		//redirect to dashboard
		echo "<script>window.location='index.php';</script>";
	}

	else
		$message = "Login Failed";
}

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Prosel | Login</title>

    <link href="library/css/bootstrap.min.css" rel="stylesheet">
    <link href="library/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="library/css/animate.css" rel="stylesheet">
    <link href="library/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
				<div>
					<img src="library/img/logo.png" width="100%" />
				</div>
				
				<h3><?php echo $message; ?></h3>
				<hr />
				
				<h3>Welcome to Prosel</h3>
				<p>Online Timekeeping System
				</p>

            </div>
            
            
            <form class="m-t" role="form" method="post" action="login.php">
                <div class="form-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
            <p class="m-t"> <small>Copyright &copy; 2018 Prosel. All Rights Reserved.</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="library/js/jquery-3.1.1.min.js"></script>
    <script src="library/js/bootstrap.min.js"></script>

</body>

</html>
