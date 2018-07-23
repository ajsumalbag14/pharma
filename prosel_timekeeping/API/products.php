<?php

require_once("../Model/ProductsModel.php");
require_once("../API/simpleREST.php"); //test only to delete later

$rest = new SimpleRest();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    
    $rest->setHttpHeaders("application/json", 401);
        echo json_encode([
            "status"=> 401,
            "message"=> "Request method must be POST"
        ]); 
}

//displayProductPerDoctor
if($_POST['method'] == 'displayProductsPerDoctor' && isset($_POST['doctorID'])) {
    
    $doctorID = $_POST['doctorID'];
    
    $products = new Products();
    $productDetails = json_decode($products->listProductsPerDoctor($doctorID)); 


    if(count($productDetails) > 0){
        $rest->setHttpHeaders("application/json", 200);
        echo json_encode([
            "status"=> 200,
            "message"=> "OK",
            "products" => $productDetails
        ]);
    }
    else //no records found
    {
        $rest->setHttpHeaders("application/json", 404);
        echo json_encode([
            "status"=> 404,
            "message"=> "no records found"
        ]);
    }   
    
}
else {
    $rest->setHttpHeaders("application/json", 401);
    echo json_encode([
    "status"=> http_response_code(),
    "message"=> "invalid request"
  ]); 
}


?>