<?php

//This is a controller to be used by Web
require_once("../Model/DoctorsVisitModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $doctorsVisit = new DoctorsVisit();

    switch($method) {
        //case "display":
        //    $output = $doctorsVisit->displayDoctorsVisit();
        //   echo $output;
        //   break;

        case "displayDoctorsVisitPerDSM":
            $userID = $data->userID;
            $output = $doctorsVisit->displayDoctorsVisitPerDSM($userID);
            echo $output;
            break;

        case "displayDoctorsVisitPerUser":
            $userID = $data->userID;
            $output = $doctorsVisit->displayDoctorsVisitPerUser($userID);
            echo $output;
            break;

        case "getDoctorVisitDetails": //display signature and google maps
            $doctorVisitID = $data->doctorVisitID;
            $output = $doctorsVisit->getDoctorVisitDetails($doctorVisitID);
            echo $output; 
            break;

/*
        case "search":
            $search_keyword = $data->search_keyword;
            $output = $products->searchDoctorsVisit($search_keyword);
            echo $output; 
            
            break;

        case "getDetails":
            $productCode = $data->productCode;
            $output = $products->getDetails($productCode);
            echo $output; 
            break;

        case "add":
            $products->addDoctorsVisitWeb($data);
            break;

        case "edit":
            $products->editProaddDoctorsVisitWebduct($data);
            break;

        case "delete":
            $productsID = $data->productID;
            $products->deleteProduct($productID);
            break;
*/
        default: //invalid request

    }
}

?>