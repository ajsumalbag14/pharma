<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class DoctorBalance {
    
    public $dbcontroller;

    public function checkDoctorBalance($params) {
        $dbcontroller = new DBController();

        $doctorID = mysqli_real_escape_string($dbcontroller->conn, $params->doctorID);
        $totalNetPrice = mysqli_real_escape_string($dbcontroller->conn, $params->totalNetPrice);

        $query = "call spCheckDoctorBalance($doctorID, $totalNetPrice)";

        $doctorBalance = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($doctorBalance); 
    }

    public function deductDoctorBalance($params) {
        $dbcontroller = new DBController();

        $doctorID = mysqli_real_escape_string($dbcontroller->conn, $params->doctorID);
        $totalNetPrice = mysqli_real_escape_string($dbcontroller->conn, $params->totalNetPrice);

        $query = "call spDeductDoctorBalance($doctorID, $totalNetPrice)";

        $doctorBalance = $dbcontroller->executeQuery($query);
        return json_encode($doctorBalance); 
    }

    //--------------------- API FUNCTIONS END

    public function displayDoctorBalance($doctorID) {
        $dbcontroller = new DBController();

        $query = "call spDisplayDoctorBalance($doctorID)";

        $doctorBalance = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctorBalance); 

    }
}




?>