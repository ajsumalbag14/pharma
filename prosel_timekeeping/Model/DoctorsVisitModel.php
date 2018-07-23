<?PHP
require_once("../Controller/DBController.php");

Class DoctorsVisit {
    
    public $dbcontroller;

    public function addDoctorsVisit($params) {
        $dbcontroller = new DBController();

        $userID = mysqli_real_escape_string($dbcontroller->conn, $params->userID);
        $doctorID = mysqli_real_escape_string($dbcontroller->conn, $params->doctorID);
        $doctorSignature = $params->doctorSignature;
        $fileType = $params->fileType;
        $locationLat = mysqli_real_escape_string($dbcontroller->conn, $params->locationLat);
        $locationLong = mysqli_real_escape_string($dbcontroller->conn, $params->locationLong);
        
        if(isset($params->remarks)) {
            $remarks = mysqli_real_escape_string($dbcontroller->conn, $params->remarks);
        }
        else {
            $remarks = '';
        }

        $query = "call spAddDoctorsVisit($userID, $doctorID, '$doctorSignature', '$fileType', $locationLat, $locationLong, '$remarks');";
        
        $doctorsVisit = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($doctorsVisit); 
    }

    //API METHODS SECTION END ----------------------------------------------------------------------------

    public function displayDoctorsVisit() {
        $dbcontroller = new DBController();
        $query = "call spDisplayProducts();";

        $doctorsVisit = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctorsVisit); 
    }

    public function displayDoctorsVisitPerDSM($userID) {
        $dbcontroller = new DBController();

        $query = "call spDisplayDoctorsVisitPerDSM($userID);";
        $doctorsVisit = $dbcontroller->executeSelectQuery($query);
        
        return json_encode($doctorsVisit); 
    }

    public function displayDoctorsVisitPerUser($userID) {
        $dbcontroller = new DBController();

        $query = "call spDisplayDoctorsVisitPerUser($userID);";
        $doctorsVisit = $dbcontroller->executeSelectQuery($query);

        return json_encode($doctorsVisit); 
    }

    public function getDoctorVisitDetails($doctorVisitID) {
        $dbcontroller = new DBController();

        $query = "call spDisplayDoctorVisitDetails($doctorVisitID);";
        $doctorsVisit = $dbcontroller->executeSelectQuery($query);

        //var_dump($doctorsVisit);

        //echo $doctorsVisit[0]["DOCTOR_VISIT_ID"];

        //base64encode the image first before passing to the client.
        $doctorsVisit[0]["DOCTOR_SIGNATURE"] = base64_encode($doctorsVisit[0]["DOCTOR_SIGNATURE"]);
        //var_dump($doctorsVisit[0]["DOCTOR_SIGNATURE"]);

        return json_encode($doctorsVisit); 
    }

    
}
?>