<?php

//This is a controller to be used by Web
require_once("../Model/AMActivityModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $amActivity = new AMActivity();

    switch($method) {
        
        case "displayAMActivity":
            $userID = $data->userID;
            $output = $amActivity->displayAMActivity($userID);
            echo $output; 
            break;

        case "getAMActivityDetails":
            $AMActivityID = $data->AMActivityID;
            $output = $amActivity->getAMActivityDetails($AMActivityID);
            echo $output; 
            break;

            

        default: //invalid request

    }
}

?>