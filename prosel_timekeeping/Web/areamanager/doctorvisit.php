<?php
$page_title = "Doctor Visit";

// include header file
include_once "../header.php";
include_once '../classes/doctorpurchase.php';
include_once '../classes/doctorvisit.php';

$doctorvisit = new DoctorVisit($db);
$doctorpurchase = new DoctorPurchase($db);

$userid = isset($_GET['userid']) ? $_GET['userid'] : die('ERROR! ID not found!');
$doctorvisit->userid = $userid;

$prep_state = $doctorvisit->getDoctorsVisit(); 
?>

<script type="text/javascript">

$(document).ready(function(){
	
	$(".btnview").click(function(event) {
		
		event.preventDefault();
		//alert($(this).attr("data"));
		var DoctorVisitID = $(this).attr("data");
		
	
		 $.post("dataparser.php", {
				method: "getDoctorVisitDetails",
				doctorvisitid: DoctorVisitID
				},
			function(data){
				var output = JSON.parse(data) 			
				
				$("#spandoctorvisitid").html(output.DOCTOR_VISIT_ID);
				$("#spanvisitdatetime").html(output.VISIT_DATETIME);
				$("#imgSignature").attr("src", "data:image/png;base64," + output.DOCTOR_SIGNATURE); 
				
				$("#spanremarks").html(output.REMARKS);
				
				initMap(output.LOCATION_LAT, output.LOCATION_LONG);
				
				//add the doctor purchase in here
				getDoctorPurchase(DoctorVisitID);
			});
	})

	function getDoctorPurchase(DoctorVisitID) {
		$.post("dataparser.php", {
			method: "getDoctorPurchase",
			doctorvisitid: DoctorVisitID
			},
		function(data){
			var output = JSON.parse(data);
			
			var table = "";
			var totalAmt = 0;
			
			table += "<tr><th>Product Code</th><th>Qty Regular</th><th>Qty Free</th><th>Price</th><th>Discount</th><th>Net Price</th></tr>";
			
			for(var i=0; i<output.length; i++) {
				table += '<tr>';
				table += '<td>'+output[i]["PRODUCT_CODE"]+'</td>';
				table += '<td>'+output[i]["QTY_REGULAR"]+'</td>';
				table += '<td>'+output[i]["QTY_FREE"]+'</td>';
				table += '<td>'+output[i]["PRICE"]+'</td>';
				table += '<td>'+output[i]["DISCOUNT"]+'</td>';
				table += '<td>'+output[i]["NET_PRICE"]+'</td>';
				table += '</tr>';
				
				totalAmt += parseFloat(output[i]["NET_PRICE"]);
			}
			//alert(totalAmt);
			table += "<tr><td colspan='5' align='right' style='font-weight:bold'>TOTAL AMOUNT</td><td>"+totalAmt.toLocaleString('en')+"</td></tr>";
			
			//$('#tableproducts > tbody:last-child').append(table);
			$('#tableproducts > tbody:last-child').html(table);
		});	
	}
	
})

function initMap(plat, plong) 
{
	plat = parseFloat(plat);
	plong = parseFloat(plong);
	
	var coordinates = {lat: plat, lng: plong};
	
	map = new google.maps.Map(document.getElementById('map'), {
	  center: coordinates,
	  zoom: 16
	});
	
	 var marker = new google.maps.Marker({position: coordinates, map: map});
}

</script>

<style type="text/css">
#map {
		width: 100%;
        height: 450px;
      }
</style>

<div class="wrapper wrapper-content animated fadeInRight">

		<div class="row">
			
			<div class="col-sm-6">
				<h3>Displaying Doctors Visit for <?php echo $_GET["name"];?></h3>
			</div>
		
		
		
			<div class='col-sm-6 right-button-margin'>
				<a href='index.php' class='btn btn-primary pull-right'>
				<span class='glyphicon  glyphicon-list-alt'></span> Back to Area Manager List
				</a>
			</div>
		</div>
			

	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-sm-4">
					<table class='table table-hover table-responsive table-bordered'>
						<tr>
							<th>Doctor Visit ID</th>
							<th>Doctor ID</th>
							<th>Visit Date Time</th>
							<th>Total Amount</th>
						</tr>
						
						<?php
						while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row); //Import variables into the current symbol table from an array

						echo "<tr>";
						echo "<td>$row[DOCTOR_VISIT_ID]</td>";
						echo "<td>$row[DOCTOR]</td>";
						echo "<td>$row[VISIT_DATETIME]</td>";
						echo "<td>$row[TOTAL]</td>";
						echo "<td>";
						
						// view doctor visit
						echo "<a href='#' data='".$row['DOCTOR_VISIT_ID']."' class=' btnview btn btn-success left-margin'>";
						echo "<span class='glyphicon glyphicon-search'></span>";
						echo "</a>";

						echo "</td>";
						echo "</tr>";
					}
						?>
					</table>
				</div>

				<div class="col-sm-8">
					<table class='table table-hover table-responsive table-bordered'>
						<tr>
							<td colspan="2">
								Doctor Visit ID: <span id="spandoctorvisitid"></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								Visit Date Time:<br />
								<span id="spanvisitdatetime"></span>
							</td>
							
						</tr>
						
						<tr>
							<td colspan="2">
								Doctor's Signature <hr />
							
							 <img id="imgSignature" style="width:100%; height: 100%" />
							</td>
						</tr>
						
						<tr>
							<td colspan="2">
							Location <hr />
							
							 <div id="map"></div>
							</td>
						</tr>
						
						<tr>
							<td colspan="4">Remarks</td>
						</tr>
						
						<tr>
							<td colspan="4"><span id="spanremarks"></span></td>
						</tr>
						
						<!--DOCTOR PURCHASE SECTION-->
						<tr>
							<td>
								<table id="tableproducts" class='table table-hover table-responsive table-bordered'>
									<tr>
										<th>Product Code</th>
										<th>Qty Regular</th>
										<th>Qty Free</th>
										<th>Price</th>
										<th>Discount</th>
										<th>Net Price</th>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>


			</div>
		</div>
	</div>
</div>	
<?php
include_once "../footer.php";
?>