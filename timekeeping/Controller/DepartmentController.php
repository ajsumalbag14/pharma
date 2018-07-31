<?php

//This is a controller to be used by Web
require_once("../Model/DepartmentModel.php");
require_once("ValidationController.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $department = new Department();

    switch($method) {
        case "display":
            $output = $department->getDepartment();
            echo $output;
            break;

        case "search":
            $search_keyword = $data->search_keyword;
            $output = $department->searchDepartment($search_keyword);
            echo $output; 
            break;

        case "get_details":
            $department_id = $data->department_id;
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
            $department_id = $data->department_id;
            $department->deleteDepartment($department_id);
            break;

        default: //invalid request

    }
}

//temp method to validate input. this will be replaced by validatecontroller class.
function validateInput($input) { 
    //$data = json_decode(file_get_contents("php://input"));
    $validatedInput;


    $validatedInput->department_name = isset($input->department_name) ? mysqli_real_escape_string($input->department_name) : null;
    $validatedInput->description = isset($input->description) ? mysqli_real_escape_string($input->description) : null;

    return json_encode($validatedInput);

}

?>