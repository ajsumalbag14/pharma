<?php
session_start();
ini_set('display_errors', 1); // see an error when they pop up
error_reporting(E_ALL); // report all php errors

$page_title= "Prosel Dashboard";

if(!isset($_SESSION["USER_ID"]) || $_SESSION["USER_ID"] == null) {
	echo "<script>window.location='login.php';</script>";
}

// include database and object files
include_once 'classes/database.php';
include_once 'classes/modules.php';
include_once 'classes/users.php';
include_once 'initial.php';
include_once 'constants.php';

$modules = new Modules($db);
$result = $modules->getModules($_SESSION["USER_ID"]);

$host = $_SERVER['HTTP_HOST'];
$parent = '/pharma/timekeeping';
$module = '/Web';
$path = 'http://'.$host.$parent.$module.'/';
$index = 'active';

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $page_title; ?></title>

    <link href="library/css/bootstrap.min.css" rel="stylesheet">
    <link href="library/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="library/css/animate.css" rel="stylesheet">
    <link href="library/css/style.css" rel="stylesheet">
	
	<link rel="shortcut icon" href="library/img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="library/img/favicon.ico" type="image/x-icon">
	
	<!-- Google Maps -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDQTpXj82d8UpCi97wzo_nKXL7nYrd4G70"></script>

</head>

<body>

<div id="wrapper">

    <?php 
		//nav is for index page only
		include_once('nav.php'); 
	?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="login.php?method=logout">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
		
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="text-left m-t-lg">
						<div class="row">
							<div class="col-sm-6">
							
								<h1>
								   Welcome <?php echo $_SESSION["NAME"];?>!
								</h1>
								<hr />
								<!--
								<p>
									It is an application skeleton for a typical web app. You can use it to quickly bootstrap your webapp projects and dev environment for these projects.
								</p>
								
								<p>Phase 1 Includes the following modules: </p>
								<ul>
									<li><strong>User Management</strong> - add and update users</li>
									<li><strong>Doctors</strong> - add and update doctors</li>
									<li><strong>Products</strong> - add and update products</li>
									<li><strong>Area Manager</strong> - View area managers per assigned DSM and above, and check their Activity and Dcotor Visit</li>
									<li><strong>Reports</strong> - View Reports of the Area Managers and enable them to save as PDF.</li>
									
								</ul>
								
								<p>Feel free to explore the features of this application.</p>
								-->
							</div>
							
							<div class="col-sm-6">
								<div class="ibox float-e-margins">
									<div class="ibox-title">
										<h5>Actions</h5>
										
									</div>
									<div class="ibox-content">
									
									<?php
										if($_SESSION["USER_TYPE"] <> "Area Manager") 
										{
									?>
											<a href="areamanager/index.php">
												<div class="widget style1 navy-bg">
													<div class="row">
														<div class="col-xs-4">
															<i class="fa fa-tablet fa-5x"></i>
														</div>
														<div class="col-xs-8 text-right">
															<span> Area Managers <br />
																View Activity & Doctors Visit
															</span>

															<h2 class="font-bold">Visit</h2>
														</div>
													</div>
												</div>
											</a>
											<a href="users/index.php">
												<div class="widget style1 yellow-bg">
													<div class="row">
														<div class="col-xs-4">
															<i class="fa fa-group fa-5x"></i>
														</div>
														<div class="col-xs-8 text-right">
															<span> 
																Users <br />
																View, add and edit Users
															</span>

															<h2 class="font-bold">Visit</h2>
														</div>
													</div>
												</div>
											</a>
											
											

											<a href="doctors/index.php">
												<div class="widget style1 lazur-bg">
													<div class="row">
														<div class="col-xs-4">
															<i class="fa fa-stethoscope fa-5x"></i>
														</div>
														<div class="col-xs-8 text-right">
															<span>  </span>
															<span> 
																Doctors <br />
																View, add and edit Doctors
															</span>

															<h2 class="font-bold">Visit</h2>
														</div>
													</div>
												</div>
											</a>
											
										<?php
										}
										else
										{
										?>
										
											<a href="doctors/index.php">
												<div class="widget style1 lazur-bg">
													<div class="row">
														<div class="col-xs-4">
															<i class="fa fa-stethoscope fa-5x"></i>
														</div>
														<div class="col-xs-8 text-right">
															<span>  </span>
															<span> 
																Doctors <br />
																View, add and edit Doctors
															</span>

															<h2 class="font-bold">Visit</h2>
														</div>
													</div>
												</div>
											</a>
										
										<?php
										}
										?>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer">
			<div>
				<strong>Copyright</strong> Prosel &copy; 2018
			</div>
		</div>

    </div>
</div>



<!-- Mainly scripts -->
<script src="library/js/jquery-3.1.1.min.js"></script>
<script src="library/js/bootstrap.min.js"></script>
<script src="library/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="library/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="library/js/inspinia.js"></script>
<script src="library/js/plugins/pace/pace.min.js"></script>


</body>

</html>
