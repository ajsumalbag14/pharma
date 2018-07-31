<?php

require_once("../Model/LoginModel.php");

$login = new Login();

$credentials = json_decode(file_get_contents("php://input"));

//$account = json_decode($login->authenticate($credentials)); 
$account = json_decode($login->webLogin($credentials)); 

//print_r($account);

if($account->result == 1) { //login authenticated  
    echo json_encode([
        "status"=> 200,
        "message"=> "Login successful. Proceeding to dashboard",
        "account" => $account
    ]); 
}
else // login failed
{
    echo json_encode([
        "status"=> 401,
        "message"=> "Login failed. Please encode a valid username/password",
        "account" => $account
    ]); 
}
    

?>