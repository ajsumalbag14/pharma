<?php

//This is a controller to be used by Web
require_once("../Model/ProductsModel.php");

$data = json_decode(file_get_contents("php://input"));
$method = $data->method;

if(isset($method)) {

    $products = new Products();

    switch($method) {
        case "display":
            $output = $products->displayProducts();
            echo $output;
            break;

        case "search":
            $search_keyword = $data->search_keyword;
            $output = $products->searchProducts($search_keyword);
            echo $output; 
            
            break;

        case "getDetails":
            $productCode = $data->productCode;
            $output = $products->getDetails($productCode);
            echo $output; 
            break;

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

        default: //invalid request

    }
}

?>