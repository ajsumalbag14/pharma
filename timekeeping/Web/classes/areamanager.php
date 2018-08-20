<?php

class AreaManager
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
	
	//areamanager activity objects
	public $areamanageractivityid;
	public $activitydatetime;
	public $activitytype;
	public $locationlat;
	public $locationlong;

	private $_userTypes;

    public function __construct($db, $_userTypes)
    {
        $this->db_conn = $db;
		$this->_userTypes = $_userTypes;
    }

	
	 // for pagination
    public function countAll()
    {
        //$sql = "SELECT USER_ID FROM " . $this->table_name . "";
		$sql = "select USER_ID from $this->table_name u inner join user_types ut on ut.USER_TYPE_ID = u.USER_TYPE_ID where ut.USER_TYPE = 'Area Manager';";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
        return $num;
    }
	
	function getAM($from_record_num, $records_per_page)
    {
		//$sql = "SELECT * FROM $this->table_name ORDER BY FIRST_NAME ASC LIMIT ?, ?";
		$sql = "select * from $this->table_name u inner join user_types ut on ut.USER_TYPE_ID = u.USER_TYPE_ID where ut.USER_TYPE = 'Area Manager' LIMIT ?, ?;";
		
		//echo $sql;
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
	}
	
	function getAllAM()
    {
		//$sql = "SELECT * FROM $this->table_name ORDER BY FIRST_NAME ASC LIMIT ?, ?";
		$sql = "select * from $this->table_name where USER_TYPE_ID = 12;";
		
		//echo $sql;
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
	}
	
	function getListOfAm()
    {
		
		if (in_array($_SESSION['USER_TYPE_ID'], $this->_userTypes)) {
			$user_que = " AND USER_ID <> ".$_SESSION["USER_ID"];
		} else {
			if($_SESSION["USER_TYPE"] == "DSM")
			{
				$user_que = " AND PARENT_USER_ID = ".$_SESSION["USER_ID"];
			}
			else if ($_SESSION["USER_TYPE"] == "RSM")
			{
				$user_que = " AND PARENT_USER_ID IN (SELECT USER_ID FROM users 
						where PARENT_USER_ID = ".$_SESSION["USER_ID"].")";
			}
		}

		$sql = "select * from $this->table_name where USER_TYPE_ID = 12 ".$user_que. " order by FIRST_NAME asc";
		
		//echo $sql;
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
	}
	
	function getUserName($id) {
		$sql = "SELECT 
					FIRST_NAME,
					LAST_NAME
		 FROM " . $this->table_name . " WHERE USER_ID = $id";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        return  $row['FIRST_NAME'].' '.$row['LAST_NAME'];
	}
	
	function getAMActivity() {
		
		//get the top 100 transactions only order by activity date time ascending 
		$sql = "select AREA_MANAGER_ACTIVITY_ID, ACTIVITY_TYPE, ACTIVITY_DATETIME from area_manager_activity where USER_ID = $this->userid ORDER BY ACTIVITY_DATETIME ASC LIMIT 0, 100;";
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}
	
	function getAMActivityDetails() {
		
		//get the details
		$sql = "SELECT * FROM area_manager_activity WHERE AREA_MANAGER_ACTIVITY_ID = $this->areamanageractivityid";
		
		$prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();
        $row = $prep_state->fetch(PDO::FETCH_ASSOC);
		
		return $row;
	}
	
	function areaManagerReport($startdate, $enddate) { 
		$sql = "SELECT 
					am.AREA_MANAGER_ACTIVITY_ID,
					CONCAT(u.FIRST_NAME, ' ', u.LAST_NAME) AS 'USER',
					am.ACTIVITY_DATETIME,
					am.ACTIVITY_TYPE,
					am.REMARKS
				 FROM area_manager_activity am
				 INNER JOIN users u ON u.USER_ID = am.USER_ID
				WHERE 
					am.USER_ID = $this->userid
				 
				";
			
		
		if($startdate <> '' && $enddate <> '')	
		{
			$sql .= " AND ACTIVITY_DATETIME BETWEEN '$startdate' AND '$enddate'";
			
		}
		
		$sql .= " ORDER BY am.ACTIVITY_DATETIME ASC;";
		
		//echo $sql;
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}
}







