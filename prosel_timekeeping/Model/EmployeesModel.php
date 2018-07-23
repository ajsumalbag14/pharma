<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class Employees {
    
    public $dbcontroller;

    public function displayEmployees() {
        $dbcontroller = new DBController();
        $query = "call spDisplayEmployees();";

        //echo $query;

        $employees = $dbcontroller->executeSelectQuery($query);
        return json_encode($employees); 
    }

    public function searchEmployee($keyword) {
        $dbcontroller = new DBController();
        $query = "call spSearchEmployees('$keyword')";
        $employees = $dbcontroller->executeSelectQuery($query);
        return json_encode($employees); 
        //return json_encode(["departments" => $employees]); 
    }

    public function getDetails($employeeID) {
        $dbcontroller = new DBController();
        $query = "call spGetDetailsEmployees($employeeID)";

        $employees = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($employees); 
        //return json_encode(["departments" => $employees]); 
    }

    public function addEmployee($param) {
        $dbcontroller = new DBController();

        $firstName = mysqli_real_escape_string($dbcontroller->conn, $param->firstName);
        $lastName = mysqli_real_escape_string($dbcontroller->conn, $param->lastName);
        $emailAddress = mysqli_real_escape_string($dbcontroller->conn, $param->emailAddress);
        $username = mysqli_real_escape_string($dbcontroller->conn, $param->username);
        $password = mysqli_real_escape_string($dbcontroller->conn, $param->password);
        $userTypeID = mysqli_real_escape_string($dbcontroller->conn, $param->userTypeID);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);

        echo $query;
     
        $query = "call spAddEmployees('$firstName', '$lastName', '$emailAddress', '$username','$password',$userTypeID,$status)";
        $dbcontroller->executeQuery($query);
    }

    public function editEmployee($param) {
        $dbcontroller = new DBController();
        $employeeID = mysqli_real_escape_string($dbcontroller->conn, $param->employeeID);
        $firstName = mysqli_real_escape_string($dbcontroller->conn, $param->firstName);
        $lastName = mysqli_real_escape_string($dbcontroller->conn, $param->lastName);
        $emailAddress = mysqli_real_escape_string($dbcontroller->conn, $param->emailAddress);
        $userTypeID = mysqli_real_escape_string($dbcontroller->conn, $param->userTypeID);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);
     
        $query = "call spEditEmployees($employeeID, '$firstName', '$lastName', '$emailAddress', $userTypeID, $status)";
        $dbcontroller->executeQuery($query);
    }

    public function deleteEmployee($employeeID) {
        $dbcontroller = new DBController();
        $query = "call spDeleteEmployees($employeeID)";
        $dbcontroller->executeQuery($query);
        
    }

    
    

}
?>