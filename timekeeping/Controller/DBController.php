<?php

class DBController {
    
    
    public $conn = ""; //made this public because of mysqli_real_escape_string requirement
    private $host = "us-cdbr-iron-east-05.cleardb.net";
    private $user = "bd219492550e73";
    private $password = "0e09a57a";
    private $database = "heroku_2414f0f6e111aa2";
    
    /*
    public $conn = ""; //made this public because of mysqli_real_escape_string requirement
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "prosel";
    */

    function __construct() {
        $conn = $this->connectDB();

        if(!empty($conn)) {
            $this->conn = $conn;
        }

    }

    function connectDB(){
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $conn;
    }

    function executeQuery($query){
        $conn = $this->connectDB();
        $result = mysqli_query($conn, $query);

    }

    //FOR GETTING THE DETAILS, RESULTSET OF ADD
    function executeSelectSingleQuery($query) { 
        $result = mysqli_query($this->conn, $query);

        $row = mysqli_fetch_assoc($result);
            
        if(!empty($row)) {
            return $row; 
        }
    
    } 

    function executeSelectQuery($query) {
        $result = mysqli_query($this->conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $resultset[] = $row;
        }
        if(!empty($resultset)) {
            return $resultset; 
        }
    
    }


}

?>