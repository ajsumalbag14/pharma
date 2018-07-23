<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class Doctors {
    
    public $dbcontroller;

    public function displayDoctorPerUser($userID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayDoctorsPerUser($userID)";

        $doctors = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctors); 
    }

    //----- ENDPOINT FUNCTIONS END

    public function displayDoctorsPerDSM($userID){
        $dbcontroller = new DBController();
        $query = "call spDisplayDoctorsPerDSM($userID);";

        //echo $query;

        $doctors = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctors); 
    }

    public function displayDoctors() {
        $dbcontroller = new DBController();
        $query = "call spDisplayDoctors()";

        $doctors = $dbcontroller->executeSelectQuery($query);

        return json_encode($doctors);
    }

    public function getDetails($doctorID){
        $dbcontroller = new DBController();
        $query = "call spGetDetailsDoctors($doctorID)";

        $doctors = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctors); 
    }

    
    public function addDoctor($param) {
        $dbcontroller = new DBController();

        $FIRST_NAME = mysqli_real_escape_string($dbcontroller->conn, $param->FIRST_NAME);
        $MIDDLE_INITIAL = mysqli_real_escape_string($dbcontroller->conn, $param->MIDDLE_INITIAL);
        $LAST_NAME = mysqli_real_escape_string($dbcontroller->conn, $param->LAST_NAME);
        $DOCTOR_SPECIALTY_ID = mysqli_real_escape_string($dbcontroller->conn, $param->DOCTOR_SPECIALTY_ID);
        $ADDRESS1 = mysqli_real_escape_string($dbcontroller->conn, $param->ADDRESS1);
        $ADDRESS2 = mysqli_real_escape_string($dbcontroller->conn, $param->ADDRESS2);
        $FREQUENCY = mysqli_real_escape_string($dbcontroller->conn, $param->FREQUENCY);
        $USER_ID = mysqli_real_escape_string($dbcontroller->conn, $param->USER_ID);
     
        $query = "call spAddDoctor('$FIRST_NAME','$MIDDLE_INITIAL','$LAST_NAME','$DOCTOR_SPECIALTY_ID','$ADDRESS1','$ADDRESS2',$FREQUENCY,$USER_ID)";
        
        //echo $query;

        $doctors = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($doctors); 
    }

    public function editDoctor($param) {
        $dbcontroller = new DBController();
        $DOCTOR_ID = mysqli_real_escape_string($dbcontroller->conn, $param->DOCTOR_ID);
        $FIRST_NAME = mysqli_real_escape_string($dbcontroller->conn, $param->FIRST_NAME);
        $MIDDLE_INITIAL = mysqli_real_escape_string($dbcontroller->conn, $param->MIDDLE_INITIAL);
        $LAST_NAME = mysqli_real_escape_string($dbcontroller->conn, $param->LAST_NAME);
        $DOCTOR_SPECIALTY_ID = mysqli_real_escape_string($dbcontroller->conn, $param->DOCTOR_SPECIALTY_ID);
        $ADDRESS1 = mysqli_real_escape_string($dbcontroller->conn, $param->ADDRESS1);
        $ADDRESS2 = mysqli_real_escape_string($dbcontroller->conn, $param->ADDRESS2);
        $FREQUENCY = mysqli_real_escape_string($dbcontroller->conn, $param->FREQUENCY);
        $USER_ID = mysqli_real_escape_string($dbcontroller->conn, $param->USER_ID);
     
        $query = "call spEditDoctor($DOCTOR_ID, '$FIRST_NAME','$MIDDLE_INITIAL','$LAST_NAME','$DOCTOR_SPECIALTY_ID','$ADDRESS1','$ADDRESS2',$FREQUENCY,$USER_ID)";
    
        $doctors = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($doctors); 
    }
}
?>