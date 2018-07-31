<?php

class Area
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "area";

    // object properties
    public $areaid;
    public $areaname;
    public $areatypeid;
    public $parentareaid;
	public $status;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	

    function getAll()
    {
		$sql = "SELECT * FROM $this->table_name;";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->execute();
        return $prep_state;
    }


}







