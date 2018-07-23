<?php

class Doctors
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "doctors";

    // object properties
    public $doctorid;
    public $firstname;
    public $middleinitial;
    public $lastname;
    public $doctorspecialtyid;
    public $address1;
	public $address2;
	public $frequency;
	public $userid;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }


    function create()
    {
        //write query
        
		$sql = "INSERT INTO $this->table_name (
			FIRST_NAME,
			MIDDLE_INITIAL,
			LAST_NAME,
			DOCTOR_SPECIALTY_ID,
			ADDRESS1,
			ADDRESS2,
			FREQUENCY,
			USER_ID
			
			)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?);
			
			
			INSERT INTO doctor_balance(DOCTOR_ID, BALANCE, EXPIRATION_DATE) VALUES (
				LAST_INSERT_ID(), 
				10000, 
				DATE_ADD(NOW(), INTERVAL 1 YEAR))
			);
			";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->firstname);
        $prep_state->bindParam(2, $this->middleinitial);
        $prep_state->bindParam(3, $this->lastname);
        $prep_state->bindParam(4, $this->doctorspecialtyid);
        $prep_state->bindParam(5, $this->address1);
		$prep_state->bindParam(6, $this->address2);
		$prep_state->bindParam(7, $this->frequency);
		$prep_state->bindParam(8, $this->userid);
		
		//echo $sql;
		

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // for pagination
    public function countAll()
    {
        //$sql = "SELECT DOCTOR_ID FROM " . $this->table_name . "";
		
		$sql = "SELECT
					d.DOCTOR_ID
					from doctors d
				INNER JOIN users u
				ON u.USER_ID = d.USER_ID";
		
		if($_SESSION["USER_TYPE"] == "Area Manager") {
			$sql .= " WHERE d.USER_ID = ". $_SESSION["USER_ID"] ." ";
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
			MIDDLE_INITIAL = '".$this->middleinitial."',
			LAST_NAME = '".$this->lastname."',
			DOCTOR_SPECIALTY_ID = '".$this->doctorspecialtyid."',
			ADDRESS1 = '".$this->address1."',
			ADDRESS2 = '".$this->address2."',
			FREQUENCY = $this->frequency,
			USER_ID = $this->userid
			WHERE DOCTOR_ID = $this->doctorid
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
		$sql = "SELECT
					d.*,
					CONCAT(u.LAST_NAME, ', ', u.FIRST_NAME) AS 'UNDER'
					from doctors d
				INNER JOIN users u
				ON u.USER_ID = d.USER_ID";
		
		if($_SESSION["USER_TYPE"] == "Area Manager") {
			$sql .= " WHERE d.USER_ID = ". $_SESSION["USER_ID"] ." ";
			
		}
		
		$sql .= " ORDER BY d.LAST_NAME ASC LIMIT ?, ?";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
    }

    // for edit user form when filling up
    function getRecord()
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE DOCTOR_ID = $this->doctorid";
	
        $prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->doctorid = $row['DOCTOR_ID'];
        $this->firstname= $row['FIRST_NAME'];
        $this->middleinitial = $row['MIDDLE_INITIAL'];
        $this->lastname = $row['LAST_NAME'];
        $this->doctorspecialtyid = $row['DOCTOR_SPECIALTY_ID'];
		$this->address1 = $row['ADDRESS1'];
		$this->address2 = $row['ADDRESS2'];
		$this->frequency = $row['FREQUENCY'];
		$this->userid = $row['USER_ID'];
		
		
    }


}







