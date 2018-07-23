<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class AM {
    
    public $dbcontroller;

    /*public function displayAMPerUser($parentUserID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayAMPerUser('$parentUserID')";

        $AMs = $dbcontroller->executeSelectQuery($query);
        return json_encode($AMs); 
    }*/

    public function displayAMPerParentUser($parentUserID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayAMPerParentUser('$parentUserID')";

        $AMs = $dbcontroller->executeSelectQuery($query);
        return json_encode($AMs); 
    }

    public function displayAMActivity($userID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayAMActivity('$userID')";

        $AMs = $dbcontroller->executeSelectQuery($query);
        return json_encode($AMs); 

    }
}
?>