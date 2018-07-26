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
	
	
    public function __construct($db)
    {
        $this->db_conn = $db;
    }

	
	//DOCTOR VISIT SECTION START
	function getDoctorsVisit()
	{
		
		$sql = "SELECT 
					dv.DOCTOR_VISIT_ID,
					CONCAT(d.FIRST_NAME, ' ', d.MIDDLE_INITIAL, ' ', d.LAST_NAME) AS 'DOCTOR',
					dv.VISIT_DATETIME,
					SUM(NET_PRICE) AS 'TOTAL'
				FROM doctor_visit dv
				INNER JOIN doctors d ON d.DOCTOR_ID = dv.DOCTOR_ID
				INNER JOIN doctor_purchase dp ON dp.DOCTOR_VISIT_ID = dv.DOCTOR_VISIT_ID
				WHERE dv.USER_ID = $this->userid 
				GROUP BY dp.DOCTOR_VISIT_ID;";
			
				
		$prep_state = $this->db_conn->prepare($sql);
		$prep_state->execute();

        return $prep_state;
	}
	
	function getDoctorVisitDetails() 
	{
		$sql = "SELECT * FROM doctor_visit where DOCTOR_VISIT_ID = $this->doctorvisitid LIMIT 0, 100;";		
		
		$prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();
        $row = $prep_state->fetch(PDO::FETCH_ASSOC);
		
		$row["DOCTOR_SIGNATURE"] = base64_encode($row["DOCTOR_SIGNATURE"]);

		return $row;
		
	}
	
	//REPORTS
	
	//SUMMARY
	function doctorVisitReport($startdate, $enddate) {
		
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
			WHERE dv.USER_ID = $this->userid";
			
		
		if ($startdate != '' && $enddate != '') {
			$sql .= " AND VISIT_DATETIME BETWEEN '$startdate' AND '$enddate 23:59:59' ";
		}
		
		$sql .= " GROUP BY dp.DOCTOR_VISIT_ID ORDER BY VISIT_DATETIME ASC;";
		
		//echo $sql;
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}
	
	//GET DETAILS OF DOCTOR
	function getDoctorReport() {
		$sql = "SELECT 
				CONCAT(d.FIRST_NAME, '', d.MIDDLE_INITIAL, ' ', d.LAST_NAME) AS 'DOCTOR',
				d.ADDRESS1
			FROM doctor_visit dv
				INNER JOIN doctors d ON d.DOCTOR_ID = dv.DOCTOR_ID
				WHERE dv.DOCTOR_VISIT_ID = $this->doctorvisitid;";
				
		
		$prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();
        $row = $prep_state->fetch(PDO::FETCH_ASSOC);
				
		return $row;
		
	}

	function getDoctorsVisitByDate($date)
	{
		
		if ($date != '') {
			$dt_que = " AND date(dv.VISIT_DATETIME) = '$date' ";
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
			WHERE dv.USER_ID = $this->userid 
				".$dt_que;

		$sql .= " GROUP BY dp.DOCTOR_VISIT_ID ORDER BY VISIT_DATETIME ASC;";
			
		//echo $sql;
		$this->query_string = $sql;
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}
	
	
}