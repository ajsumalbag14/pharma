<?PHP
require_once("../Controller/DBController.php");

Class Login {
    
    public $dbcontroller;

    public function authenticate($param) {

        //print_r($param);

        $dbcontroller = new DBController();
        $username = mysqli_real_escape_string($dbcontroller->conn, $param->username);
        $password = mysqli_real_escape_string($dbcontroller->conn, $param->password);
        $locationLat = mysqli_real_escape_string($dbcontroller->conn, $param->locationLat);
        $locationLong = mysqli_real_escape_string($dbcontroller->conn, $param->locationLong);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);

        $query = "call spLogin('$username','$password', $locationLat, $locationLong, '$remarks')";

        $account = $dbcontroller->executeSelectSingleQuery($query);

        return json_encode($account);
    }

    public function logout($param) {
        $dbcontroller = new DBController();
        $userID = mysqli_real_escape_string($dbcontroller->conn, $param->userID);
        $locationLat = mysqli_real_escape_string($dbcontroller->conn, $param->locationLat);
        $locationLong = mysqli_real_escape_string($dbcontroller->conn, $param->locationLong);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);

        
        $query = "call spLogout($userID, $locationLat, $locationLong, '$remarks')";

        $account = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($account);
    }

    public function webLogin($param) {
        $dbcontroller = new DBController();
        $username = mysqli_real_escape_string($dbcontroller->conn, $param->username);
        $password = mysqli_real_escape_string($dbcontroller->conn, $param->password);

        $query = "call spWebLogin('$username','$password')";

        $account = $dbcontroller->executeSelectSingleQuery($query);

        return json_encode($account);
    }
}
?>