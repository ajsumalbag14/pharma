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

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $page_title; ?></title>

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

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                     <div class="dropdown profile-element">
                            <a  class="dropdown-toggle" href="#">
                            <span class="clear"> 
								<span class="block m-t-xs"> 
									<strong class="font-bold"><?php echo $_SESSION["NAME"];?></strong>
								</span> 
								
							</span> </a>
                           
                    </div>
                   
                </li>
				
				
			<?php
			if($_SESSION["USER_TYPE"] <> "Area Manager") {
				?>

				<li class="active">
					<a href="../index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				
				<li>
					<a href="../users/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span></a>
				</li>
				
				<li>
					<a href="../doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
				</li>
				
				<li>
					<a href="../products/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Products</span></a>
				</li>
				
				<li>
					<a href="../areamanager/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Area Manager</span></a>
				</li>
				
				<li>
					<a href="../doctorvisitreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctor Visit Report</span></a>
				</li>
				
				<li>
					<a href="../amactivityreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">AM Activity Report</span></a>
				</li>
			
			<?php
			}
			else
			{
			?>
				<li class="active">
					<a href="index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				<li>
					<a href="doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
				</li>
			<?php
			}
			?>
				
				<?php
				/*
					//navigation in here will fix this
					while ($row = $result->fetch(PDO::FETCH_ASSOC)){ 
						extract($row); //Import variables into the current symbol table from an array
					?>
				
						
						<li>
							<a href=
							"../<?php echo $row["PAGE_URI"]; ?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo $row["MODULE_NAME"]; ?></span></a>
						</li>
					<?php
					} */
					?>
            </ul>
        </div>
    </nav>

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