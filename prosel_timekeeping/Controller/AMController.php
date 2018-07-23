<?php

//This is a controller to be used by Web
require_once("../Model/AMModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $am = new AM();

    switch($method) {
        /*case "display":
            $parentUserID = $data->parentUserID;
            $output = $am->displayAMPerUser($parentUserID);
            echo $output; 
            break;
            */
        case "displayAMPerParentUser":
            $parentUserID = $data->parentUserID;
            $output = $am->displayAMPerParentUser($parentUserID);
            echo $output; 
            break;
        
        case "displayAMPerParentUser":
            $parentUserID = $data->parentUserID;
            $output = $am->displayAMPerParentUser($parentUserID);
            echo $output; 
            break;


        default: //invalid request

    }
}

?>