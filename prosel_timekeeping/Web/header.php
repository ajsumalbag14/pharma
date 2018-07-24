<?php
session_start();
ini_set('display_errors', 1); // see an error when they pop up
error_reporting(E_ALL); // report all php errors

if($_SESSION["USER_ID"] == null) {
	echo "<script>window.location='../login.php';</script>";
}

// include database and object files
include_once '../classes/database.php';
include_once '../classes/modules.php';
include_once '../initial.php';

$modules = new Modules($db);
$result = $modules->getModules($_SESSION["USER_ID"]);

$host = $_SERVER['HTTP_HOST'];
$parent = '/pharma/prosel_timekeeping';
$module = '/Web';
$path = 'http://'.$host.$parent.$module.'/';
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $page_title; ?></title>

    <link rel="shortcut icon" href="../library/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../library/img/favicon.ico" type="image/x-icon">

    <link href="../library/css/bootstrap.min.css" rel="stylesheet">
    <link href="../library/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../library/css/animate.css" rel="stylesheet">
    <link href="../library/css/style.css" rel="stylesheet">
	
	<script type="text/javascript" src="../library/js/jquery-3.3.1.min.js"></script>
	
	<!-- Google Maps -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70"></script>

</head>

<body>

<div id="wrapper">

	<?php
		include_once('nav.php'); 
	?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
			
				<div class="navbar-header">
                    
					<h1 style="margin:10px;"><?php echo $page_title; ?></h1>
                    
                </div>
			
                
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="../login.php?method=logout">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>