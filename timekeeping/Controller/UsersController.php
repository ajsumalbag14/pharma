<?php

//This is a controller to be used by Web
require_once("../Model/UsersModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $users = new Users();

    switch($method) {
        case "display":
            $usersResult = $users->displayUsers();
            echo $usersResult;
            break;

        case "displayAllUsers":
            $usersResult = $users->displayAllUsers();
            echo $usersResult;
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


        case "add":
            $users->addUser($data);
            break;

        case "edit":
            $users->editUser($data);
            break;
/*
        case "delete":
            $productsID = $data->productID;
            $products->deleteProduct($productID);
            break;

        default: //invalid request
*/
    }
}

?>