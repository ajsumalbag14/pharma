<?php

class Area
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "area";

    // object properties
    public $area_id;
    public $area_name;
    public $area_type_id;
    public $parent_area_id;
	public $status;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	

    function getAll()
    {
		$sql = "SELECT * FROM $this->table_name ORDER BY AREA_NAME ASC";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();
        return $prep_state;
    }

    function getAreaById($id)
    {
		$sql = "SELECT * FROM $this->table_name where AREA_ID = ".$id;
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->area_id = $row['AREA_ID'];
        $this->area_name= $row['AREA_NAME'];
        $this->area_type_id = $row['AREA_TYPE_ID'];
        $this->parent_area_id = $row['PARENT_AREA_ID'];
    }

    function create()
    {
        //write query
        
		$sql = "INSERT INTO $this->table_name (
			AREA_NAME,
			AREA_TYPE_ID,
			PARENT_AREA_ID,
			STATUS
			)
			VALUES (?, ?, ?, ?);
			";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->area_name);
        $prep_state->bindParam(2, $this->area_type_id);
        $prep_state->bindParam(3, $this->parent_area_id);
        $prep_state->bindParam(4, $this->status);
        
		//echo $sql;
		
        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

    function edit($id)
    {
        
		$sql = "UPDATE $this->table_name SET 
			AREA_NAME = '".$this->area_name."',
			AREA_TYPE_ID = ".$this->area_type_id.",
			PARENT_AREA_ID = ".$this->parent_area_id."
			WHERE AREA_ID = $id
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

    function disable($id)
    {
        
		$sql = "UPDATE $this->table_name SET 
			STATUS = 0
			WHERE AREA_ID = $id
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

    function enable($id)
    {
        
		$sql = "UPDATE $this->table_name SET 
			STATUS = 1
			WHERE AREA_ID = $id
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


}







