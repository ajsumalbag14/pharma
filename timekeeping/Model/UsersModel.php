<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class Users {
    
    public $dbcontroller;

    public function displayUsers() {
        $dbcontroller = new DBController();
        $query = "call spDisplayUsers()";

        $users = $dbcontroller->executeSelectQuery($query);
        return json_encode($users); 
    }

    public function displayAllUsers() {
        $dbcontroller = new DBController();
        $query = "call spDisplayAllUsers()";

        $users = $dbcontroller->executeSelectQuery($query);
        return json_encode($users); 
    }

    public function searchUsers($keyword) {
        $dbcontroller = new DBController();
        $query = "call spSearchUsers('$keyword')";
        $users = $dbcontroller->executeSelectQuery($query);
        return json_encode($users); 
    }

    public function getDetails($userID) {
        $dbcontroller = new DBController();
        $query = "call spGetDetailsUsers($userID)";

        $users = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($users); 
    }


    public function addUser($param) {
        $dbcontroller = new DBController();

        $firstName = mysqli_real_escape_string($dbcontroller->conn, $param->firstName);
        $middleName = mysqli_real_escape_string($dbcontroller->conn, $param->middleName);
        $lastName = mysqli_real_escape_string($dbcontroller->conn, $param->lastName);
        $userTypeID = mysqli_real_escape_string($dbcontroller->conn, $param->userTypeID);
        $username = mysqli_real_escape_string($dbcontroller->conn, $param->username);
        $password = mysqli_real_escape_string($dbcontroller->conn, $param->password);
        $areaID = mysqli_real_escape_string($dbcontroller->conn, $param->areaID);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);
        $parentUserID = mysqli_real_escape_string($dbcontroller->conn, $param->parentUserID);
     
        $query = "call spAddUser('$firstName', '$middleName', '$lastName', $userTypeID, '$username','$password',$areaID, $status, '$remarks', $parentUserID)";

        $users = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($users); 
    }

    public function editUser($param) {
        $dbcontroller = new DBController();
        $userID = mysqli_real_escape_string($dbcontroller->conn, $param->userID);
        $firstName = mysqli_real_escape_string($dbcontroller->conn, $param->firstName);
        $middleName = mysqli_real_escape_string($dbcontroller->conn, $param->middleName);
        $lastName = mysqli_real_escape_string($dbcontroller->conn, $param->lastName);
        $userTypeID = mysqli_real_escape_string($dbcontroller->conn, $param->userTypeID);
        $username = mysqli_real_escape_string($dbcontroller->conn, $param->username);
        $password = mysqli_real_escape_string($dbcontroller->conn, $param->password);
        $areaID = mysqli_real_escape_string($dbcontroller->conn, $param->areaID);
        $status = mysqli_real_escape_string($dbcontroller->conn, $param->status);
        $remarks = mysqli_real_escape_string($dbcontroller->conn, $param->remarks);
        $parentUserID = mysqli_real_escape_string($dbcontroller->conn, $param->parentUserID);
     

        $query = "call spEditUser($userID,'$firstName', '$middleName', '$lastName', $userTypeID, '$username','$password',$areaID, $status, '$remarks', $parentUserID)";

        $users = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($users); 
    }
/*
    public function deleteProduct($productID) {
        $dbcontroller = new DBController();
        $query = "call spDeleteEmployees($employeeID)";
        $dbcontroller->executeQuery($query);
        
    }
    */
}
?>