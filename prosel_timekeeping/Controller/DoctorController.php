<?php

//This is a controller to be used by Web
require_once("../Model/DoctorModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $doctors = new Doctors();

    switch($method) {
        case "displayDoctors":
            $output = $doctors->displayDoctors();
            echo $output;
            break;

        case "search":
            $search_keyword = $data->search_keyword;
            $output = $doctors->searchDoctors($search_keyword);
            echo $output; 
            
            break;

        case "getDetails":
            $doctorID = $data->doctorID;
            $output = $doctors->getDetails($doctorID);
            echo $output; 
            break;

        case "displayDoctorsPerDSM":
            $userID = $data->userID;
            $output = $doctors->displayDoctorsPerDSM($userID);
            echo $output;
            break;

        case "add":
            //$doctors->addDoctor($data);
            $output = $doctors->addDoctor($data);
            echo $output;
            break;

        case "edit":
            $output = $doctors->editDoctor($data);
            echo $output;
            break;

        default: //invalid request

    }
}

?>