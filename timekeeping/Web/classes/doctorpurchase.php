<?php

class DoctorPurchase
{
    // table name definition and database connection
    public $db_conn;
    public $table_name = "doctor_purchase";

    // object properties

	public $doctorpurchaseid;
	public $doctorvisitid;
	public $productcode;
	public $qtyregular;
	public $qtyfree;
	public $price;
	public $discount;
	public $netprice;
	public $datecreated;
	

    public function __construct($db)
    {
        $this->db_conn = $db;
    }
	
	//from jquery .post request
	function getDoctorPurchase() {
		$sql = "SELECT
				PRODUCT_CODE, 
				QTY_REGULAR,
				QTY_FREE,
				PRICE, DISCOUNT,
				NET_PRICE
			FROM doctor_purchase
			WHERE DOCTOR_VISIT_ID = $this->doctorvisitid";
			
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
		
		$result = $prep_state->fetchAll();

        return $result;
	}
	
	function getDoctorPurchaseReport() {
		
		$sql = "SELECT dp.*,
					p.PRODUCT_DESCRIPTION,
					p.GENERIC_NAME_OR_PACKING_SHADE,
					p.SIZE
				FROM doctor_purchase dp
				INNER JOIN products p on p.PRODUCT_CODE = dp.PRODUCT_CODE
				WHERE dp.DOCTOR_VISIT_ID = $this->doctorvisitid";
			
		$prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();
		
		$result = $prep_state->fetchAll();

        return $result;
	}
}







