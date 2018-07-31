<?php
$page_title = "Doctor Visit Report";

include_once "../header.php";
include_once '../classes/doctorvisit.php';

?>

<?php

$doctorvisitid = isset($_GET['doctorvisitid']) ? $_GET['doctorvisitid'] : die('ERROR! doctorvisitid not found!');

// include database and object files
include_once '../classes/database.php';
include_once '../classes/doctorvisit.php';
include_once '../classes/doctorpurchase.php';
include_once '../initial.php';


// instantiate user object
$doctorvisit = new DoctorVisit($db);
$doctorpurchase = new DoctorPurchase($db);

$doctorvisit->doctorvisitid = $doctorvisitid;
$doctor = $doctorvisit->getDoctorReport();

$doctorpurchase->doctorvisitid = $doctorvisitid;
$purchasedproducts = $doctorpurchase->getDoctorPurchaseReport();


?>	

<style type="text/css">
.header {
	background-color:#EEE;
}
</style>

</head>
<body>

<div class="wrapper wrapper-content animated fadeInRight" style="background-color:#FFF">
	<div class="row">
		<div class="col-lg-12">

			<div class="row">
				<div class="col-sm-12">
					<table class='table table-hover table-responsive table-bordered'>
						<tr >	
							<td>SOLD TO</td>
							<td><?php echo $doctor["DOCTOR"]; ?> </td>
							<td class="header" align="center">TERMS</td>
							<td class="header"align="center">APPROVED BY</td>
							<td class="header" align="center">DATE</td>
						</tr>
						
						<tr>
							<td>ADDRESS</td>
							<td><?php echo $doctor["ADDRESS1"]; ?> </td>
							<td>PDC 30 MR TO COLLECT</td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
						
						<tr>
							<td colspan="2">&nbsp; </td>
							<td>PDC 60 TWO CHECKS</td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
						
						<tr>
							<td colspan="2" class="header">SPECIAL NOTE ON DELIVERY ORDER </td>
							<td>PDC 90 THREE CHECKS</td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
						
						<tr>
							<td rowspan="4" colspan="2"></td>
							<td>COD MR TO COLLECT</td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
						
						<tr>
							<td>OTHERS</td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
						
						<tr align="center">
							<td>SALESMAN CODE</td>
							<td>MR. TERR. CODE</td>
							<td>SPECIALIZATION </td>
						</tr>
						
						<tr>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
							<td>&nbsp; </td>
						</tr>
					</table>
				</div>
			</div>


					
			<div class="row">
				<div class="col-sm-12">
					<table class='table table-hover table-responsive table-bordered'>
					<tr align="center" class="header">
						<td rowspan="2">PRODUCT CODE</td>
						<td rowspan="2">PRODUCT DESCRIPTION</td>
						<td rowspan="2">SIZE</td>
						<td colspan="2" align="center">QUANTITY</td>
						<td rowspan="2">PRICE</td>
						<td rowspan="2">DISCOUNT</td>
						<td rowspan="2">NET PRICE</td>
						<td rowspan="2">GENERIC NAME OR PACKING/SHADE</td>
					</tr>
					
					<tr align="center" class="header">
						<td>REGULAR</td>
						<td>FREE</td>
					</tr>
						<!--loop in here-->
						
						<?php
						$total = 0;
						
						for($i=0; $i<count($purchasedproducts); $i++) 
						{
							
							?>
							<tr>
							<td><?php echo $purchasedproducts[$i]["PRODUCT_CODE"];?></td>
							<td><?php echo $purchasedproducts[$i]["PRODUCT_DESCRIPTION"];?></td>
							<td><?php echo $purchasedproducts[$i]["SIZE"];?></td>
							<td><?php echo $purchasedproducts[$i]["QTY_REGULAR"];?></td>
							<td><?php echo $purchasedproducts[$i]["QTY_FREE"];?></td>
							<td><?php echo $purchasedproducts[$i]["PRICE"];?></td>
							<td><?php echo $purchasedproducts[$i]["DISCOUNT"];?></td>
							<td><?php echo $purchasedproducts[$i]["NET_PRICE"];?></td>
							<td><?php echo $purchasedproducts[$i]["GENERIC_NAME_OR_PACKING_SHADE"];?></td>
							</tr>
							
							
							<?php
							
							$total += floatval($purchasedproducts[$i]["NET_PRICE"]);
						}
						
						?>
						
						
					
					
					<tr>
						<td colspan="7" align="right">TOTAL</td>
						<td><?php echo number_format($total,2); ?></td>
					</tr>
					</table>
				</div>
				
			</div>
				
			<div class="row">
				<div class="col-sm-12">
					<table class='table table-hover table-responsive table-bordered'>	
						<tr align="center" class="header"> 
							<td colspan="3">LAST PURCHASE</td>
							<td colspan="3">LAST PAYMENT</td>
							<td rowspan="2">BALANCE TO DATE</td>
						</tr>
						
						<tr class="header" align="center">
							<td>DATE</td>
							<td>DR. NO.</td>
							<td>AMOUNT</td>
							<td>DATE</td>
							<td>PR. NO.</td>
							<td>AMOUNT</td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						
						<tr  align="center">
							<td colspan="2">&nbsp;</td>
							<td>&nbsp;</td>
							<td class="header">SO RECEIVED BY:</td>
							<td class="header">SO PROCESSED BY:</td>
							<td class="header">SO APPROVED BY:</td>
							<td class="header">DSM</td>
						</tr>
						
						<tr  align="center">
							<td colspan="2">CUSTOMER'S SIGNATURE OVER PRINTED NAME</td>
							<td>MR'S SIGNATURE OVER PRINTED NAME</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						
						
					</table>
				</div>
			</div>
		</div>	
	</div>
</div>	
</body>
</html>