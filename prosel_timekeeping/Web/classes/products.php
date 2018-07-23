<?php

class Products
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "products";

    // object properties
    public $productcode;
    public $productdescription;
    public $size;
    public $genericnameorpackingshade;
    public $price;
    public $quantity;
	public $status;
	public $dateadded;


    public function __construct($db)
    {
        $this->db_conn = $db;
    }


    function create()
    {
		$sql = "INSERT INTO $this->table_name (
			PRODUCT_CODE,
			PRODUCT_DESCRIPTION,
			SIZE,
			GENERIC_NAME_OR_PACKING_SHADE,
			PRICE,
			QUANTITY,
			STATUS
			
			)
			VALUES (?, ?, ?, ?, ?, ?, ?)";

        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $this->productcode);
        $prep_state->bindParam(2, $this->productdescription);
        $prep_state->bindParam(3, $this->size);
        $prep_state->bindParam(4, $this->genericnameorpackingshade);
        $prep_state->bindParam(5, $this->price);
		$prep_state->bindParam(6, $this->quantity);
		$prep_state->bindParam(7, $this->status);
		

        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }

    }

    // for pagination
    public function countAll()
    {
        $sql = "SELECT PRODUCT_CODE FROM " . $this->table_name . "";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        $num = $prep_state->rowCount(); //Returns the number of rows affected by the last SQL statement
        return $num;
    }


    function update()
    {
        //$sql = "UPDATE " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email, mobile = :mobile, category_id  = :category_id  WHERE id = :id";
		
		$sql = "UPDATE $this->table_name SET 
			PRODUCT_DESCRIPTION = '".$this->productdescription."',
			SIZE = '".$this->size."',
			GENERIC_NAME_OR_PACKING_SHADE = '".$this->genericnameorpackingshade."',
			PRICE = $this->price,
			QUANTITY = $this->quantity,
			STATUS = $this->status
			WHERE PRODUCT_CODE = '".$this->productcode."'
		";
		
        // prepare query
        $prep_state = $this->db_conn->prepare($sql);

     
        // execute the query
        if ($prep_state->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getAll($from_record_num, $records_per_page)
    {		
		$sql = "SELECT * FROM $this->table_name ORDER BY PRODUCT_CODE ASC LIMIT ?, ?";
		
        $prep_state = $this->db_conn->prepare($sql);

        $prep_state->bindParam(1, $from_record_num, PDO::PARAM_INT); //Represents the SQL INTEGER data type.
        $prep_state->bindParam(2, $records_per_page, PDO::PARAM_INT);


        $prep_state->execute();

        return $prep_state;
        $db_conn = NULL;
    }

    // for edit user form when filling up
    function getRecord()
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE PRODUCT_CODE = '$this->productcode'";
		

        $prep_state = $this->db_conn->prepare($sql);
        
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->productcode = $row['PRODUCT_CODE'];
        $this->productdescription = $row['PRODUCT_DESCRIPTION'];
        $this->size = $row['SIZE'];
        $this->genericnameorpackingshade = $row['GENERIC_NAME_OR_PACKING_SHADE'];
        $this->price = $row['PRICE'];
		$this->quantity = $row['QUANTITY'];
		$this->status = $row['STATUS'];
		
    }


}







