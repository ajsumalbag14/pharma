<?php

//This is a controller to be used by Web
require_once("../Model/DoctorBalanceModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $doctorBalance = new DoctorBalance();

    switch($method) {
        case "displayDoctorBalance":
            $doctorID = $data->doctorID;
            $output = $doctorBalance->displayDoctorBalance($doctorID);
            echo $output;
            break;

/*
        case "add":
            $products->addProduct($data);
            break;

        case "edit":
            $products->editProduct($data);
            break;

        case "delete":
            $productsID = $data->productID;
            $products->deleteProduct($productID);
            break;
*/
        default: //invalid request

    }
}

?>