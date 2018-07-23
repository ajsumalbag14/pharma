<?PHP
require_once("../Controller/DBController.php");

Class Area {
    
    public $dbcontroller;

    public function displayArea() {
        $dbcontroller = new DBController();
        $query = "call spDisplayArea()";

        $area = $dbcontroller->executeSelectQuery($query);
        return json_encode($area); 
    }
}
?>