<?php

require_once("../Model/LoginModel.php");
require_once("../Model/LogModel.php");
require_once("../API/simpleREST.php");

$rest = new SimpleRest();


//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    
    $rest->setHttpHeaders("application/json", 401);
        echo json_encode([
            "status"=> 401,
            "message"=> "Request method must be POST"
        ]); 
}

//check if there is a data inside
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['locationLat']) && isset($_POST['locationLong'])) {
    //$credentials = json_decode($_POST['data']);
    $credentials = new stdClass();
    
    $credentials->username = $_POST['username'];
    $credentials->password = $_POST['password'];
    $credentials->locationLat = $_POST['locationLat'];
    $credentials->locationLong = $_POST['locationLong'];

    //optional
    if(isset($_POST['remarks']))
    {
        $credentials->remarks = $_POST['remarks'];
    }

    $login = new Login();
    $account = json_decode($login->authenticate($credentials)); 

    if($account->result == 1) { //login successful
        //return the results in here.

        $rest->setHttpHeaders("application/json", 200);
        echo json_encode([
            "status"=> 200,
            "message"=> "Login successful. Proceeding to dashboard",
            "account" => $account
        ]); 
        
    }
    else // login failed
    {   
        $rest->setHttpHeaders("application/json", 401); 
        echo json_encode([
            "status"=> http_response_code(),
            "message"=> "Login failed. Please encode a valid username/password"
        ]);
    }
}
else {
    $rest->setHttpHeaders("application/json", 401);
    echo json_encode([
    "status"=> http_response_code(),
    "message"=> "Invalid request returned by user"
  ]); 
}

function addSystemLog($params)
{
    $log = new Log();
    $log->addSystemLogs($params);
}

?>