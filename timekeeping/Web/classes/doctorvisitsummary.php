<?php

class DoctorVisit
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "doctor_visit";


	//object for doctorvisit
	public $doctorvisitid;
	public $userid;
	public $doctorid;
	public $visitdatetime;
	public $doctorsignature;
	public $locationlat;
	public $locationlong;
	public $remarks;

	public $query_string;
	private $_userTypes; 	
	
    public function __construct($db, $_userTypes)
    {
		$this->db_conn = $db;
		$this->_userTypes = $_userTypes;
    }

	function getDoctorsVisits($request)
	{
		$user_que = '';
		$dt_que = '';

		$user_que = in_array($request['user_type_id'], $this->_userTypes) ? " u.USER_ID <> ".$request['parent_user_id'] : " u.PARENT_USER_ID = ".$request['parent_user_id']; 
		
		if (isset($request['startdate']) && isset($request['enddate'])) {
			$dt_que = " AND date(dv.VISIT_DATETIME) BETWEEN '".$request['startdate']."' AND '".$request['enddate']."' ";
		}

		$sql = "SELECT 
				dv.DOCTOR_VISIT_ID,
				CONCAT(u.FIRST_NAME, ' ', u.LAST_NAME) AS 'USER',
				CONCAT(d.FIRST_NAME, ' ', d.MIDDLE_INITIAL, ' ', d.LAST_NAME) AS 'DOCTOR',
				dv.VISIT_DATETIME,
				SUM(NET_PRICE) AS 'TOTAL'
			FROM doctor_visit dv
			INNER JOIN doctors d ON d.DOCTOR_ID = dv.DOCTOR_ID
			INNER JOIN users u ON u.USER_ID = dv.USER_ID
			INNER JOIN doctor_purchase dp ON dp.DOCTOR_VISIT_ID = dv.DOCTOR_VISIT_ID
			WHERE 
			".$user_que.$dt_que;

		$sql .= " GROUP BY dp.DOCTOR_VISIT_ID ORDER BY VISIT_DATETIME ASC;";
			
		//echo $sql;
		$this->query_string = $sql;
		
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