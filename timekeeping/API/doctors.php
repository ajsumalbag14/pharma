<?php

require_once("../Model/DoctorModel.php");
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

//ListDoctorsPerSalesAgent

if($_POST['method'] == 'listDoctorsPerUser' && isset($_POST['userID'])) {
    
    $userID = $_POST['userID'];
    
    $doctor = new Doctors();
    $doctorDetails = json_decode($doctor->displayDoctorPerUser($userID)); 

    
    if(count($doctorDetails) > 0){
        $rest->setHttpHeaders("application/json", 200);
        echo json_encode([
            "status"=> 200,
            "message"=> "OK",
            "doctors" => $doctorDetails
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