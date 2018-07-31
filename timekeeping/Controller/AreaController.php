<?php

//This is a controller to be used by Web
require_once("../Model/AreaModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $area = new Area();

    switch($method) {
        case "displayArea":
            $output = $area->displayArea();
            echo $output;
            break;
    }
}

?>