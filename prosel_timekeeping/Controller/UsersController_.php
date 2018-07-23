<?php

//This is a controller to be used by Web
require_once("../Model/UsersModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $users = new Users();

    switch($method) {
        case "display":
            //echo 'here';
            $output = $users->displayUsersList();
            echo $output;
            break;

        case "search":
            $search_keyword = $data->search_keyword;
            $output = $users->searchUsers($search_keyword);
            echo $output; 
            
            break;

        case "getDetails":
            $userID = $data->userID;
            $output = $users->getDetails($userID);
            echo $output; 
            break;

/*
        case "add":
            $output = $users->addEmployee($data);
            echo $output; 
            break;

        case "edit":
            $users->editEmployee($data);
            break;

        default: //invalid request
*/
    }
}

?>