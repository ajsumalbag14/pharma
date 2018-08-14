<?php

class DoctorPurchase
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "doctor_purchase";


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

	function getDoctorsPurchase($request)
	{
		$user_que = '';
		$dt_que = '';

		$user_que = in_array($request['user_type_id'], $this->_userTypes) ? " b.USER_ID <> ".$request['parent_user_id'] : " b.USER_ID in (select USER_ID FROM users WHERE PARENT_USER_ID = ".$request['parent_user_id'].")"; 
		
		if (isset($request['startdate']) && isset($request['enddate'])) {
			$dt_que = " AND date(b.VISIT_DATETIME) BETWEEN '".$request['startdate']."' AND '".$request['enddate']."' ";
		}

		//SELECT a.DOCTOR_VISIT_ID,b.VISIT_DATETIME, b.DOCTOR_ID, b.USER_ID, 
		//a.PRODUCT_CODE,a.QTY_REGULAR,a.QTY_FREE,a.PRICE,a.DISCOUNT,a.NET_PRICE 
				
		$sql = "
				SELECT b.VISIT_DATETIME, b.DOCTOR_ID, b.USER_ID, 
				a.PRODUCT_CODE,a.QTY_REGULAR,a.PRICE,a.NET_PRICE 
				
				FROM 
				doctor_purchase a left join doctor_visit b
				on a.DOCTOR_VISIT_ID = b.DOCTOR_VISIT_ID
				WHERE 
			".$user_que.$dt_que;

		$sql .= "group by a.DOCTOR_VISIT_ID, a.PRODUCT_CODE 
				ORDER BY b.VISIT_DATETIME DESC;";
			
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