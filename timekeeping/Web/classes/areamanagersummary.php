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
	public $parent_name;

	public $query_string;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	
	function getAttendance($request = [])
    {
		$type = '';
		$area_id = '';
		$area_manager = '';

		$user_que = $request['user_type'] == 'Administrator' ? " u.USER_ID <> ".$request['parent_user_id'] : " u.PARENT_USER_ID = ".$request['parent_user_id']; 

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
			where 
			".$user_que." 
			AND date(at.ACTIVITY_DATETIME) = '".$request['startdate']."'
			".$type."
			".$area_id."
			".$area_manager." 
			ORDER BY at.ACTIVITY_DATETIME DESC";
		} else {
		// multiple dates
			$sql = "select u.AREA_ID,u.USER_ID,u.PARENT_USER_ID, u.FIRST_NAME, u.LAST_NAME,
			date(at.ACTIVITY_DATETIME) as dt, at.ACTIVITY_DATETIME,at.ACTIVITY_TYPE,at.REMARKS  
			from $this->table_name u 
			inner join area_manager_activity at on at.USER_ID = u.USER_ID 
			where 
			".$user_que." 
			AND date(at.ACTIVITY_DATETIME) BETWEEN '".$request['startdate']."' AND '".$request['enddate']."'
			".$type."
			".$area_id."
			".$area_manager."
			ORDER BY at.ACTIVITY_DATETIME DESC";
		} 

		//echo $sql;
		$this->query_string = $sql;
		
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

        $this->parent_name = $row['FIRST_NAME'].' '.$row['LAST_NAME'];
	}
	

	function getDateDiff($start_date, $end_date) {

		$sd = strtotime($start_date);
		$ed = strtotime($end_date);
		$datediff = $ed - $sd;

		$result = (round($datediff / (60 * 60 * 24)) + 1);

		return $result;
	}
}