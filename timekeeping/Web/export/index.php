<?php
include('../classes/database.php');
$database = new Database();
$db = $database->getConnection();
    
if (isset($_POST['query'])) {
    $stmt = $db->prepare($_POST['query']);
    $stmt->execute();
    
    
    $columnHeader ='';

    switch ($_POST['rpt']) {
    case 1:    
        $columnHeader = "AREA ID"."\t"."AM ID"."\t"."UNDER TO"."\t"."FIRST NAME"."\t"."LAST NAME"."\t"."DATE"."\t"."DATETIME"."\t"."TYPE"."\t"."REMARKS"."\t";
        break;
    case 2:
        $columnHeader = "DOCTOR_VISIT_ID"."\t"."USER"."\t"."DOCTOR"."\t"."VISIT_DATETIME";
        break;
    case 3:
        $columnHeader = "VISIT"."\t"."AM ID"."\t"."DOCTOR ID"."\t"."PRODUCT_CODE"."\t"."QTY"."\t"."UNIT"."\t"."TOTAL";
        break;
    }
    
    $setData='';
    
    while ($rec = $stmt->FETCH(PDO::FETCH_ASSOC)) {
        $rowData = '';
        foreach ($rec as $value) {
            $value = '"' . $value . '"' . "\t";
            $rowData .= $value;
        }
        $setData .= trim($rowData)."\n";
    }
    
    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$_POST['module']."-".date('YmdGis').".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    echo ucwords($columnHeader)."\n".$setData."\n";
}
 
?>