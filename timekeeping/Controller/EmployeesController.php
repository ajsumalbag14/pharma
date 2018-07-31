<?php

//This is a controller to be used by Web
require_once("../Model/EmployeesModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $employees = new Employees();

    switch($method) {
        case "display":
            $output = $employees->displayEmployees();
            echo $output;
            break;

        case "search":
            $search_keyword = $data->search_keyword;
            $output = $employees->searchEmployee($search_keyword);
            echo $output; 
            
            break;

        case "getDetails":
            $employeeID = $data->employeeID;
            $output = $employees->getDetails($employeeID);
            echo $output; 
            break;

        case "add":
            $employees->addEmployee($data);
            break;

        case "edit":
            $employees->editEmployee($data);
            break;

        case "delete":
            $employeeID = $data->employeeID;
            $employees->deleteEmployee($employeeID);
            break;

        default: //invalid request

    }
}

?>