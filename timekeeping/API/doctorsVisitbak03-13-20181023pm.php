<?php

require_once("../Model/DoctorsVisitModel.php");
require_once("../Model/ProductsModel.php"); //find the sales order method in here
require_once("../API/simpleREST.php"); //test only to delete later
require_once("../Model/DoctorsPurchaseModel.php");
require_once("../Model/DoctorBalanceModel.php");

$rest = new SimpleRest();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    
    $rest->setHttpHeaders("application/json", 401);
        echo json_encode([
            "status"=> 401,
            "message"=> "Request method must be POST"
        ]); 
}


//doctors visit and purchase products
if(isset($_POST['userID']) && isset($_POST['doctorID']) && isset($_FILES['doctorSignature']) && isset($_POST['locationLat']) && isset($_POST['locationLong'])) {

    //change the signature with uploading feature start
    //validate if the uploaded file is image -if true, proceed to uploading
    //if invalid upload, exit the transaction

    $check = getimagesize($_FILES["doctorSignature"]["tmp_name"]);
        if($check !== false) {
            $fileType = $check["mime"];
            
            $image = $_FILES['doctorSignature']['tmp_name'];
            $imgContent = addslashes(file_get_contents($image));

        }
         else {
            //echo "File is not an image.";
            $rest->setHttpHeaders("application/json", 401);
            echo json_encode([
                "status"=> http_response_code(),
                "message"=> "Cannot transact. Please upload a valid image."
            ]); 
            exit;
         }

    //uploading feature end
    
    $doctorsVisitParams = new stdClass();
    
    $doctorsVisitParams->userID = $_POST['userID'];
    $doctorsVisitParams->doctorID = $_POST['doctorID'];
    //$doctorsVisitParams->doctorSignature = $_POST['doctorSignature'];
    $doctorsVisitParams->doctorSignature = $imgContent;
    $doctorsVisitParams->fileType = $fileType;
    $doctorsVisitParams->locationLat = $_POST['locationLat'];
    $doctorsVisitParams->locationLong = $_POST['locationLong'];

    if(isset($_POST['remarks'])) {
        $doctorsVisitParams->remarks = $_POST['remarks'];
    }
    
    $doctorsVisit = new DoctorsVisit();
    $response = json_decode($doctorsVisit->addDoctorsVisit($doctorsVisitParams));
    
    if($response->result == 1){ //success

        if(isset($_POST['salesOrders'])) //process if there are records
        {
            $salesOrder = new stdClass();
            $salesOrder = json_encode($_POST['salesOrders']);
            
            //to check this section

            $totalNetPrice = 0; //this holds the overall total of the orders

            //loop within sales orders and do the comparison
            for($i=0; $i<count($salesOrder); $i++)  {
                $totalQty = $salesOrder[$i]->qtyRegular + $salesOrder[$i]->qtyFree;

                //put into a variable to be used by the model for checking the product stocks
                $productQtyParams = new stdClass();
                $productQtyParams->productCode = $salesOrder[$i]->productCode;
                $productQtyParams->totalOrderQuantity = $totalQty;

                $productsObj = new Products();
                $productStocksCheck = json_decode($productsObj->checkProductStocks($productQtyParams));

                if($productStocksCheck->result == 0) {
                    $rest->setHttpHeaders("application/json", 401);
                    echo json_encode([
                        "status"=> http_response_code(),
                        "message"=> "Cannot transact. Orders in product code: $productQtyParams->productCode was more than quantity / stocks in the database."
                    ]); 
                    exit;
                }

                $totalNetPrice += $salesOrder[$i]->netPrice; //loop and get the total net price
            }

            //validation #2 - check if the doctor has sufficient balance

            $doctorBalanceParams = new stdClass();
            $doctorBalanceParams->doctorID = $doctorsVisitParams->doctorID;
            $doctorBalanceParams->totalNetPrice = $totalNetPrice;
    
            $doctorBalance = new DoctorBalance();
            $HasSufficientBalance = json_decode($doctorBalance->checkDoctorBalance($doctorBalanceParams));

            if($HasSufficientBalance->result == 0) //not capable of buying. exit the system and prompt the user
            {
                $rest->setHttpHeaders("application/json", 401);
                    echo json_encode([
                        "status"=> http_response_code(),
                        "message"=> "Cannot transact. The doctor has insufficient balance."
                    ]); 
                    exit;
            }

            //if the code gets in here, that means all the quantities are valid. set another for loop but this time to add records in the database

            //echo 'we are here! Proceeding with add function';
        
            $doctorsVisitID = $response->doctorsVisitID; // the doctors visit id

            for($i=0; $i<count($salesOrder); $i++)  {

                $doctorPurchaseParams = new stdClass();
                $doctorPurchaseParams->doctorsVisitID = $doctorsVisitID;
                $doctorPurchaseParams->productCode = $salesOrder[$i]->productCode;
                $doctorPurchaseParams->qtyRegular = $salesOrder[$i]->qtyRegular;
                $doctorPurchaseParams->qtyFree = $salesOrder[$i]->qtyFree;
                $doctorPurchaseParams->price = $salesOrder[$i]->price;
                $doctorPurchaseParams->discount = $salesOrder[$i]->discount;
                $doctorPurchaseParams->netPrice = $salesOrder[$i]->netPrice;

                $doctorsPurchase = new DoctorsPurchase();
                $doctorsPurchaseResponse = json_decode($doctorsPurchase->addDoctorsPurchase($doctorPurchaseParams)); 

                //print_r($doctorsPurchase);
            }

            //deduct the total net amount to the doctor
            $doctorBalance->deductDoctorBalance($doctorBalanceParams);


            //if the code gets here, that means the transaction has been successful! send a reply that the transactions have been successful
            $rest->setHttpHeaders("application/json", 200);
            echo json_encode([
                "status"=> http_response_code(),
                "message"=> "Transaction successful. File upload completed; Doctor Visit completed;"
            ]); 
            
        }
        else {
            $rest->setHttpHeaders("application/json", 200);
            echo json_encode([
                "status"=> http_response_code(),
                "message"=> "Doctors visit successfully added to the database but no sales order added. Please check your parameter"
            ]);
        }

        //proceed with adding the sales order in loop

        // steps:
        // get all the orders and convert in json format
        // loop and assign to variable
        // validation check - check the total order quantity per item to the product stocks. 
        //      if the total quantity >= product stocks - return error and purchase order will be cancelled.
        //      if valid - proceed with loop adding per product convert_code
        //      return successfully added all records
    }
}
else {
    $rest->setHttpHeaders("application/json", 401);
    echo json_encode([
        "status"=> http_response_code(),
        "message"=> "invalid request. Please check if the parameters may be incorrect, incomplete or misspelled."
  ]); 
}


?>