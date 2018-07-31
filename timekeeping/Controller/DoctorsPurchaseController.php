<?php

//This is a controller to be used by Web
require_once("../Model/DoctorsPurchaseModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $doctorsPurchase = new DoctorsPurchase();

    switch($method) {
        case "displayDoctorPurchasePerDoctorVisit":
            $doctorVisitID = $data->doctorVisitID;
            $output = $doctorsPurchase->displayDoctorPurchasePerDoctorVisit($doctorVisitID);
            echo $output; 
            
            break;

        case "displayDoctorPurchaseTotalPerDoctorVisit":
            $doctorVisitID = $data->doctorVisitID;
            $output = $doctorsPurchase->displayDoctorPurchaseTotalPerDoctorVisit($doctorVisitID);
            echo $output; 
            
            break;

        default: //invalid request
    }
}

?>