<?php

require_once("../Model/LoginModel.php");
require_once("../Model/LogModel.php");
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

//LOGOUT
//check if there is a data inside
if(isset($_POST['userID']) && isset($_POST['locationLat']) && isset($_POST['locationLong'])) {
    
    $credentials = new stdClass();
    
    $credentials->userID = $_POST['userID'];
    $credentials->locationLat = $_POST['locationLat'];
    $credentials->locationLong = $_POST['locationLong'];

    //optional
    if(isset($_POST['remarks']))
    {
        $credentials->remarks = $_POST['remarks'];
    }
    
    $login = new Login();
    $account = json_decode($login->logout($credentials)); 


    if($account->result == 1){
        $rest->setHttpHeaders("application/json", 200);
        echo json_encode([
            "status"=> 200,
            "message"=> "Logout successful"
        ]);
    }
    else {
        $rest->setHttpHeaders("application/json", 404);
        echo json_encode([
            "status"=> 404,
            "message"=> "employee id not found. Logging to database unsuccessful"
        ]);
    }
}
else {
    $rest->setHttpHeaders("application/json", 401);
        echo json_encode([
            "status"=> 401,
            "message"=> "invalid request"
        ]);
}
?>