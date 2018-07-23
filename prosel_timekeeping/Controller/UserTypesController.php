<?php

//This is a controller to be used by Web
require_once("../Model/UserTypesModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $users = new UserTypes();

    switch($method) {
        case "displayActiveUserTypes":
            $userTypesResult = $users->displayActiveUserTypes();
            echo $userTypesResult;
            break;
    }
}
?>
