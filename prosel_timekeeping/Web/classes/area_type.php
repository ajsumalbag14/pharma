<?php

class AreaType
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "area_types";

    // object properties
    public $area_type_id;
    public $area_type;
	public $status;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	

    function getAll()
    {
		$sql = "SELECT * FROM $this->table_name ORDER BY AREA_TYPE ASC";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();
        return $prep_state;
    }


}







