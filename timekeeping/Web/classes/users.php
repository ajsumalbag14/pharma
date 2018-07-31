<?php

class Users
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "users";

    // object properties
    public $userid;
    public $firstname;
    public $middlename;
    public $lastname;
    public $usertypeid;
    public $username;
	public $password;
	public $areaid;
	public $status;
	public $remarks;
	public $parentuserid;


    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	
	function login() {
		$sql = "SELECT u.*, ut.USER_TYPE FROM users u
				INNER JOIN user_types ut ON ut.USER_TYPE_ID = u.USER_TYPE_ID
				WHERE u.USERNAME = '$this->username' and u.PASSWORD = MD5('$this->password') AND u.STATUS = 1;";
				
		//echo $sql;
		
		$prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();
        $row = $prep_state->fetch(PDO::FETCH_ASSOC);
				
		return $row;
	}

    function create()
    {
        //write query
        
		$sql = "INSERT INTO $this->table_name (
			FIRST_NAME,
			MIDDLE_NAME,
			LAST_NAME,
			USER_TYPE_ID,
			USERNAME,
			PASSWORD,
			AREA_ID,
			STATUS,
			REMARKS,
			PARENT_USER_ID
			
			)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->firstname);
        $prep_state->bindParam(2, $this->middlename);
        $prep_state->bindParam(3, $this->lastname);
        $prep_state->bindParam(4, $this->usertypeid);
        $prep_state->bindParam(5, $this->username);
		$prep_state->bindParam(6, $this->password);
		$prep_state->bindParam(7, $this->areaid);
		$prep_state->bindParam(8, $this->status);
		$prep_state->bindParam(9, $this->remarks);
		$prep_state->bindParam(10, $this->parentuserid);

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // for pagination
    public function countAll()
    {
        //$sql = "SELECT USER_ID FROM " . $this->table_name . "";
		
		$sql = "SELECT 
				u.USER_ID
			 FROM users u
			INNER JOIN area a ON a.AREA_ID = u.AREA_ID";
		
		if($_SESSION["USER_TYPE"] == "DSM")
		{
			$sql .= " where u.PARENT_USER_ID = ".$_SESSION["USER_ID"];
		}
		else if ($_SESSION["USER_TYPE"] == "RSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"].")";
		}
		else if ($_SESSION["USER_TYPE"] == "NSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"]."))";
			
		}

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
        return $num;
    }


    function update()
    {
		
		$sql = "UPDATE $this->table_name SET 
			FIRST_NAME = '".$this->firstname."',
			MIDDLE_NAME = '".$this->middlename."',
			LAST_NAME = '".$this->lastname."',
			USER_TYPE_ID = $this->usertypeid,
			USERNAME = '".$this->username."',";
		
		
		if($this->password <> null || $this->password <> "")
		{
			$sql .= " PASSWORD = '".$this->password."',";
		}
	 
			$sql .= " AREA_ID = $this->areaid,
			STATUS = $this->status,
			REMARKS = '".$this->remarks ."',
			PARENT_USER_ID = $this->parentuserid
			
			WHERE USER_ID = $this->userid
		";
		
        // prepare query
        $prep_state = $this->db_conn->prepare($sql);

     
        // execute the query
        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getAll($from_record_num, $records_per_page)
    {
		//if ADMIN, PRES, VP DOWN THE LINE, NO CHANGES
		//echo $_SESSION["USER_TYPE"];
		
		$sql = "SELECT 
				u.USER_ID,
				CONCAT(u.LAST_NAME, ', ', u.FIRST_NAME) AS 'NAME',
				a.AREA_NAME,
				ut.DESCRIPTION,
				u.USERNAME, 
				u.STATUS,
				u.REMARKS,
				u.PARENT_USER_ID
			 FROM users u
			INNER JOIN area a ON a.AREA_ID = u.AREA_ID
			INNER JOIN user_types ut ON ut.USER_TYPE_ID = u.USER_TYPE_ID";
			
		
		if($_SESSION["USER_TYPE"] == "DSM")
		{
			$sql .= " where u.PARENT_USER_ID = ".$_SESSION["USER_ID"];
		}
		else if ($_SESSION["USER_TYPE"] == "RSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"].")";
		}
		else if ($_SESSION["USER_TYPE"] == "NSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"]."))";
			
		}
		
		$sql .= " ORDER BY u.USERNAME ASC LIMIT $from_record_num, $records_per_page";
		
		//echo $sql;
		
        $prep_state = $this->db_conn->prepare($sql);

        //$prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        //$prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
    }
	
	function getAllUsers()
    {
		//if ADMIN, PRES, VP DOWN THE LINE, NO CHANGES
		//echo $_SESSION["USER_TYPE"];
		
		$sql = "SELECT 
				u.USER_ID,
				CONCAT(u.LAST_NAME, ', ', u.FIRST_NAME) AS 'NAME',
				a.AREA_NAME,
				ut.DESCRIPTION,
				u.USERNAME, 
				u.STATUS,
				u.REMARKS,
				u.PARENT_USER_ID
			 FROM users u
			INNER JOIN area a ON a.AREA_ID = u.AREA_ID
			INNER JOIN user_types ut ON ut.USER_TYPE_ID = u.USER_TYPE_ID";
			
		
		if($_SESSION["USER_TYPE"] == "DSM")
		{
			$sql .= " where u.PARENT_USER_ID = ".$_SESSION["USER_ID"];
		}
		else if ($_SESSION["USER_TYPE"] == "RSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"].")";
		}
		else if ($_SESSION["USER_TYPE"] == "NSM")
		{
			$sql .= " where u.PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID IN (SELECT USER_ID FROM users 
					where PARENT_USER_ID = ".$_SESSION["USER_ID"]."))";
			
		}
		
		$sql .= " ORDER BY u.USERNAME ASC";
		
		//echo $sql;
		
        $prep_state = $this->db_conn->prepare($sql);

        //$prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        //$prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
    }

	
	function getName() {
		 $sql = "SELECT 
					FIRST_NAME,
					LAST_NAME
		 FROM " . $this->table_name . " WHERE USER_ID = $this->parentuserid";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->firstname = $row['FIRST_NAME'];
		$this->lastname = $row['LAST_NAME'];
		
	}

    // for edit user form when filling up
    function getRecord()
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE USER_ID = '$this->userid'";
	
        $prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->userid = $row['USER_ID'];
        $this->firstname= $row['FIRST_NAME'];
        $this->middlename = $row['MIDDLE_NAME'];
        $this->lastname = $row['LAST_NAME'];
        $this->usertypeid = $row['USER_TYPE_ID'];
		$this->username = $row['USERNAME'];
		$this->password = $row['PASSWORD'];
		$this->areaid = $row['AREA_ID'];
		$this->status = $row['STATUS'];
		$this->remarks = $row['REMARKS'];
		$this->parentuserid = $row['PARENT_USER_ID'];
		
    }	
	
	//Display all AREA MANAGERs
	
	function getAllAM()
    {
        //select all data
        
		$sql = "select * from $this->table_name u inner join user_types ut on ut.USER_TYPE_ID = u.USER_TYPE_ID where ut.USER_TYPE = 'Area Manager';";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }
	
	function getAMActivity() {
		$sql = "select * from area_manager_activity where USER_ID = $this->userid;";
		
		 $prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->userid = $row['USER_ID'];
        $this->firstname= $row['FIRST_NAME'];
        $this->middlename = $row['MIDDLE_NAME'];
        $this->lastname = $row['LAST_NAME'];
        $this->usertypeid = $row['USER_TYPE_ID'];
		$this->username = $row['USERNAME'];
		$this->password = $row['PASSWORD'];
		$this->areaid = $row['AREA_ID'];
		$this->remarks = $row['STATUS'];
		$this->parentuserid = $row['PARENT_USER_ID'];
	}
	
	function getRecordsExceptAM() {
		
		$sql = "SELECT u.USER_ID, 
					CONCAT (u.FIRST_NAME, ' ', u.LAST_NAME) AS 'NAME'
					
				 FROM users u
				INNER JOIN user_types ut ON ut.USER_TYPE_ID = u.USER_TYPE_ID
				WHERE ut.USER_TYPE <> 'Area Manager';";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();
        return $prep_state;
	}

}







