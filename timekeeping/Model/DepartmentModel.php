<?PHP
require_once("../Controller/DBController.php");
//require_once("../Controller/RESTController.php");

//Class Department extends REST{
Class Department {
    
    public $dbcontroller;

    public function getDepartment() {
        $dbcontroller = new DBController();
        $query = "call spDisplayDepartment()";
        $department = $dbcontroller->executeSelectQuery($query);
        return json_encode(["departments" => $department]); 
    }


    public function searchDepartment($keyword) {
        $dbcontroller = new DBController();
        $query = "call spSearchDepartment('$keyword')";
        $department = $dbcontroller->executeSelectQuery($query);
        return json_encode(["departments" => $department]); 
    }

     public function getDetails($department_id) {
        $dbcontroller = new DBController();
        $query = "call spGetDetailsDepartment($department_id)";
        $department = $dbcontroller->executeSelectQuery($query);
        return json_encode(["departments" => $department]); 
    }


    public function addDepartment($param) {
        $dbcontroller = new DBController();

        $department_name = mysqli_real_escape_string($dbcontroller->conn, $param->department_name);
        $description = mysqli_real_escape_string($dbcontroller->conn, $param->description);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);
     
        $query = "call spAddDepartment('$department_name', '$description', $status)";
        $dbcontroller->executeQuery($query);
    }

    
    public function editDepartment($param) {    
        $dbcontroller = new DBController();

        //extract the parameters and assign it into variable
        $department_id = mysqli_real_escape_string($dbcontroller->conn, $param->department_id);
        $department_name = mysqli_real_escape_string($dbcontroller->conn, $param->department_name);
        $description = mysqli_real_escape_string($dbcontroller->conn, $param->description);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);

        $query = "call spEditDepartment($department_id, '$department_name', '$description', $status)";        
        $dbcontroller->executeQuery($query);
        
    }


    public function deleteDepartment($department_id) {
        $dbcontroller = new DBController();
        $query = "call spDeleteDepartment($department_id)";
        $dbcontroller->executeQuery($query);
        
    }
    
}
?>