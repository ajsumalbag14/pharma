<?php

include_once '../classes/database.php';
include_once '../classes/areamanager.php';
include_once '../classes/doctorvisit.php';
include_once '../classes/doctorpurchase.php';
include_once '../initial.php';

// instantiate user object
$areamanager = new AreaManager($db);
$doctorvisit = new DoctorVisit($db);
$doctorpurchase = new DoctorPurchase($db);

//getAMActivityDetails
if(isset($_POST["amactivityid"]) && $_POST["method"] == "getAMActivityDetails")
{
	$areamanager->areamanageractivityid = $_POST["amactivityid"];
	
	$prep_state = $areamanager->getAMActivityDetails();
	echo json_encode($prep_state);
}

//getDoctorsVisitDetails
if(isset($_POST["doctorvisitid"]) && $_POST["method"] == "getDoctorVisitDetails")
{
	$doctorvisit->doctorvisitid = $_POST["doctorvisitid"];
	
	$prep_state = $doctorvisit->getDoctorVisitDetails();
	echo json_encode($prep_state);
}

//getDoctorPurchase
if(isset($_POST["doctorvisitid"]) && $_POST["method"] == "getDoctorPurchase")
{
	$doctorpurchase->doctorvisitid = $_POST["doctorvisitid"];
	
	$result = $doctorpurchase->getDoctorPurchase();
	echo json_encode($result);
}
?>