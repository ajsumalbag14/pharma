<?php

class Modules
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "users";

    // object properties
    public $moduleid;
    public $modulename;
   
    public function __construct($db)
    {
        $this->db_conn = $db;
    }

	
	function getModules($userid) {
		
		$sql = "SELECT m.* FROM user_module_access uma
					INNER JOIN modules m ON M.MODULE_ID = uma.MODULE_ID
					INNER JOIN users u ON u.USER_TYPE_ID = uma.USER_TYPE_ID
					WHERE u.USER_ID = $userid;";
		
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
	}
	
}







