<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class Modules {
    
    public $dbcontroller;

    public function loadModuleAccessPerUserType($userTypeID) {
        $dbcontroller = new DBController();
        $query = "call loadModuleAccessPerUserType($userTypeID)";

        $output = $dbcontroller->executeSelectQuery($query);
        return json_encode($output); 
    }

    public function displayModules() {
        $dbcontroller = new DBController();
        $query = "call spDisplayModules($userTypeID)";

        $output = $dbcontroller->executeSelectQuery($query);
        return json_encode($output); 
    }

    


}
?>