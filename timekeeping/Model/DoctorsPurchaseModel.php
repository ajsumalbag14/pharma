<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class DoctorsPurchase {
    
    public $dbcontroller;

    public function addDoctorsPurchase($params) {
        $dbcontroller = new DBController();

        $doctorsVisitID = mysqli_real_escape_string($dbcontroller->conn, $params->doctorsVisitID);
        $productCode = mysqli_real_escape_string($dbcontroller->conn, $params->productCode);
        $qtyRegular = mysqli_real_escape_string($dbcontroller->conn, $params->qtyRegular);
        $qtyFree = mysqli_real_escape_string($dbcontroller->conn, $params->qtyFree);
        $price = mysqli_real_escape_string($dbcontroller->conn, $params->price);
        $discount = mysqli_real_escape_string($dbcontroller->conn, $params->discount);
        $netPrice = mysqli_real_escape_string($dbcontroller->conn, $params->netPrice);
        
        $query = "call spAddDoctorPurchase($doctorsVisitID, '$productCode', $qtyRegular, $qtyFree, $price, $discount, $netPrice)";

        $doctors = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($doctors); 
    }


/// API METHODS FINISH
    public function displayDoctorPurchasePerDoctorVisit($doctorVisitID) {
        $dbcontroller = new DBController();
        
        //$query = "call spAddDoctorPurchase($doctorsVisitID, '$productCode', $qtyRegular, $qtyFree, $price, $discount, $netPrice)";

        $query = "call spDisplayDoctorPurchasePerDoctorVisit($doctorVisitID);";

        $doctorPurchase = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctorPurchase); 
    }

    public function displayDoctorPurchaseTotalPerDoctorVisit($doctorVisitID) {
        $dbcontroller = new DBController();

        $query = "call displayDoctorPurchaseTotalPerDoctorVisit($doctorVisitID);";

        //echo $query;

        $doctorPurchase = $dbcontroller->executeSelectQuery($query);
        return json_encode($doctorPurchase); 
    }

}
?>