<?php

require_once("../Model/DepartmentModel.php");
//require_once("../Controller/RESTController.php");

header('Content-Type: application/json');

//$REST = new REST();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

if(isset($_POST["method"])) {

    $method = $_POST["method"];

    if(isset($_POST['data'])) {
        $data = json_decode($_POST['data']);

        print_r($data);
    }

    $department = new Department();
    switch($method) {
        case "display":
            $output = $department->getDepartment();
            echo $output;
            break;

        case "search":
            $search_keyword = $_POST["search_keyword"];
            $output = $department->searchDepartment($search_keyword);
            echo $output; 
            break;

        case "get_details":
            $department_id = $_POST["department_id"];
            $output = $department->getDetails($department_id);
            echo $output; 
            break;

        case "add":
            $department->addDepartment($data);
            break;

        case "edit":
            $department->editDepartment($data);
            break;

        case "delete":
            $department_id = $_POST["department_id"];
            $department->deleteDepartment($department_id);
            break;

        default: //invalid request
            echo "invalid request";
    }
}


?>