<?PHP
require_once("../Controller/DBController.php");

Class Log {
    
    public $dbcontroller;

    public function addSystemLogs($param)
    {
        $dbcontroller = new DBController();

        $user_id = mysqli_real_escape_string($dbcontroller->conn, $param->user_id);
        $module_id = mysqli_real_escape_string($dbcontroller->conn, $param->module_id);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);

        $query = "call spAddSystemLogs($user_id,$module_id, $location_lat, $location_long, '$remarks')";

        $account = $dbcontroller->executeQuery($query);
    }

    // this is logging feature for sales agent
    public function addSalesAgentLogs($param) {

        $dbcontroller = new DBController();
        $user_id = mysqli_real_escape_string($dbcontroller->conn, $param->user_id);
        $module_id = mysqli_real_escape_string($dbcontroller->conn, $param->module_id);
        $location_lat = mysqli_real_escape_string($dbcontroller->conn, $param->location_lat);
        $location_long = mysqli_real_escape_string($dbcontroller->conn, $param->location_long);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);

        $query = "call spAddSalesAgentLogs($user_id,$module_id, $location_lat, $location_long, '$remarks')";

        $account = $dbcontroller->executeQuery($query);
    }
}
?>