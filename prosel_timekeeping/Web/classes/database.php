<?php

class Database
{


	
    private $host = "us-cdbr-iron-east-05.cleardb.net";
	private $db_name = "heroku_2414f0f6e111aa2";
    private $username = "bd219492550e73";
    private $password = "0e09a57a";
    

/*
    // used to connect to the database
    private $host = "localhost";
    private $db_name = "prosel";
    private $username = "root";
    private $password = "";
*/
	
    public $db_conn;

    // get the database connection
    public function getConnection()
    {
        $this->db_conn = null;

        try {
            $this->db_conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Database Connection Error: " . $exception->getMessage();
        }
        return $this->db_conn;
    }
}

