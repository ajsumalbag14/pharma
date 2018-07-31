<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class AMActivity {
    
    public $dbcontroller;

    public function displayAMActivity($userID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayAMActivity('$userID')";

        $AMs = $dbcontroller->executeSelectQuery($query);
        return json_encode($AMs); 

    }

    public function getAMActivityDetails($AMActivityID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayAMActivityDetails('$AMActivityID')";

        $AMActivityDetails = $dbcontroller->executeSelectQuery($query);
        return json_encode($AMActivityDetails); 

    }
}
?>