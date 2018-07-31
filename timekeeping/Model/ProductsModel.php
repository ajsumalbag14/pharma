<?PHP
require_once("../Controller/DBController.php");

//Class Department extends REST{
Class Products {
    
    public $dbcontroller;

    public function listProductsPerDoctor($doctorID) {
        $dbcontroller = new DBController();
        $query = "call spDisplayProductsPerDoctor($doctorID)";

        //echo $query;

        $products = $dbcontroller->executeSelectQuery($query);
        return json_encode($products); 
    }

    public function checkProductStocks($params) {
        $dbcontroller = new DBController();

        $productCode = $params->productCode;
        $totalOrderQuantity = $params->totalOrderQuantity;

        $query = "call spCheckProductStocks('$productCode', $totalOrderQuantity)";

        $productStocksCheck = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($productStocksCheck); 
    }

    //API functions end --------------------------------------------------------------------------------------------------------


    public function displayProducts() {
        $dbcontroller = new DBController();
        $query = "call spDisplayProducts();";

        //echo $query;

        $products = $dbcontroller->executeSelectQuery($query);
        return json_encode($products); 
    }

    public function searchProducts($keyword) {
        $dbcontroller = new DBController();
        $query = "call spSearchProducts('$keyword')";
        $products = $dbcontroller->executeSelectQuery($query);
        return json_encode($products); 
        
    }

    public function getDetails($productCode) {
        $dbcontroller = new DBController();
        $query = "call spGetDetailsProducts('$productCode')";

        $products = $dbcontroller->executeSelectSingleQuery($query);
        return json_encode($products); 
    }

    public function addProduct($param) {
        $dbcontroller = new DBController();


        $PRODUCT_CODE = mysqli_real_escape_string($dbcontroller->conn, $param->PRODUCT_CODE);
        $PRODUCT_DESCRIPTION = mysqli_real_escape_string($dbcontroller->conn, $param->PRODUCT_DESCRIPTION);
        $SIZE = mysqli_real_escape_string($dbcontroller->conn, $param->SIZE);
        $GENERIC_NAME_OR_PACKING_SHADE = mysqli_real_escape_string($dbcontroller->conn, $param->GENERIC_NAME_OR_PACKING_SHADE);
        $PRICE = mysqli_real_escape_string($dbcontroller->conn, $param->PRICE);
        $STATUS = mysqli_real_escape_string($dbcontroller->conn, $param->STATUS);
        $QUANTITY = mysqli_real_escape_string($dbcontroller->conn, $param->QUANTITY);

     
        $query = "call spAddProducts('$PRODUCT_CODE', '$PRODUCT_DESCRIPTION', '$SIZE', '$GENERIC_NAME_OR_PACKING_SHADE',$PRICE,$STATUS,$QUANTITY)";
        $dbcontroller->executeQuery($query);
    }

    public function editProduct($param) {
        $dbcontroller = new DBController();

        $PRODUCT_CODE = mysqli_real_escape_string($dbcontroller->conn, $param->PRODUCT_CODE);
        $PRODUCT_DESCRIPTION = mysqli_real_escape_string($dbcontroller->conn, $param->PRODUCT_DESCRIPTION);
        $SIZE = mysqli_real_escape_string($dbcontroller->conn, $param->SIZE);
        $GENERIC_NAME_OR_PACKING_SHADE = mysqli_real_escape_string($dbcontroller->conn, $param->GENERIC_NAME_OR_PACKING_SHADE);
        $PRICE = mysqli_real_escape_string($dbcontroller->conn, $param->PRICE);
        $STATUS = mysqli_real_escape_string($dbcontroller->conn, $param->STATUS);
        $QUANTITY = mysqli_real_escape_string($dbcontroller->conn, $param->QUANTITY);
     
        //echo $query;

        $query = "call spEditProducts('$PRODUCT_CODE', '$PRODUCT_DESCRIPTION', '$SIZE', '$GENERIC_NAME_OR_PACKING_SHADE',$PRICE,$STATUS,$QUANTITY)";
        $dbcontroller->executeQuery($query);
    }

    public function deleteProduct($productID) {
        $dbcontroller = new DBController();
        $query = "call spDeleteEmployees($employeeID)";
        $dbcontroller->executeQuery($query);
        
    }
}
?>