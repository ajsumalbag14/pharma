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


	public $query_string;

    public function __construct($db)
    {
        $this->db_conn = $db;
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
	
	function getAttendance($request = [])
    {
		$type = '';
		$area_id = '';
		$area_manager = '';

		//filter type
		if ($request['type'] != 'All') {
			$type = " AND at.ACTIVITY_TYPE = '".$request['type']."'";
		}

		//filter by area id
		if ($request['area_id'] > 0) {
			$area_id = " AND u.AREA_ID = ".$request['area_id'];
		}

		//filter by area manager
		if ($request['area_manager'] > 0) {
			$area_manager = " AND at.USER_ID = ".$request['area_manager'];
		}

		// single day
		if ($request['datediff'] == 0) {
			$sql = "select u.AREA_ID,u.USER_ID,u.PARENT_USER_ID, u.FIRST_NAME, u.LAST_NAME,
			date(at.ACTIVITY_DATETIME) as dt, at.ACTIVITY_DATETIME,at.ACTIVITY_TYPE,at.REMARKS 
			from $this->table_name u 
			inner join area_manager_activity at on at.USER_ID = u.USER_ID 
			where u.parent_user_id = ".$request['parent_user_id']."
			AND date(at.ACTIVITY_DATETIME) = '".$request['startdate']."'
			".$type."
			".$area_id."
			".$area_manager." 
			ORDER BY u.USER_ID, at.ACTIVITY_DATETIME ASC";
		} else {
		// multiple dates
			$sql = "select u.AREA_ID,u.USER_ID,u.PARENT_USER_ID, u.FIRST_NAME, u.LAST_NAME,
			date(at.ACTIVITY_DATETIME) as dt, at.ACTIVITY_DATETIME,at.ACTIVITY_TYPE,at.REMARKS  
			from $this->table_name u 
			inner join area_manager_activity at on at.USER_ID = u.USER_ID 
			where u.parent_user_id = ".$request['parent_user_id']."
			AND date(at.ACTIVITY_DATETIME) BETWEEN '".$request['startdate']."' AND '".$request['enddate']."'
			".$type."
			".$area_id."
			".$area_manager."
			ORDER BY u.USER_ID, at.ACTIVITY_DATETIME ASC";
		} 

		//echo $sql;
		$this->query_string = $sql;
		
        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
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
			
		
		if($startdate != '' && $enddate != '')	
		{
			$sql .= " AND ACTIVITY_DATETIME BETWEEN '$startdate' AND '$enddate 23:59:59'";
			
		}
		
		$sql .= " ORDER BY AM.ACTIVITY_DATETIME ASC;";
		
		//echo $sql;
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}

	function getDateDiff($start_date, $end_date) {

		$sd = strtotime($start_date);
		$ed = strtotime($end_date);
		$datediff = $ed - $sd;

		$result = (round($datediff / (60 * 60 * 24)) + 1);

		return $result;
	}
}







