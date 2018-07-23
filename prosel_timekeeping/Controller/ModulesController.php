<?php

//This is a controller to be used by Web
require_once("../Model/ModulesModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $modules = new Modules();

    switch($method) {        
        case "loadModuleAccessPerUserType":
            $userTypeID = $data->userTypeID;

            $output = $modules->loadModuleAccessPerUserType($userTypeID);
            echo $output; 
            
        break;
        
        case "displayModules":
            $output = $modules->displayModules();
            echo $output; 
        break;

            
    }
}

?>