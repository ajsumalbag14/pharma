<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class UserTypes {

public $dbcontroller;

    public function displayActiveUserTypes() {
        $dbcontroller = new DBController();
        $query = "call spDisplayActiveUserTypes()";

        $users = $dbcontroller->executeSelectQuery($query);
        return json_encode($users); 
    }
}
?>