<?php
$page_title = "Area Manager Activity";

// include database and object files
include_once '../classes/areamanager.php';
include_once "../header.php";

// isset() is a PHP function used to verify if ID is there or not
$userid = isset($_GET['userid']) ? $_GET['userid'] : die('ERROR! ID not found!');

// instantiate database and user object
$areamanager = new AreaManager($db);
$areamanager->userid = $userid;
// include header file


$prep_state = $areamanager->getAMActivity(); //Name of the PHP variable to bind to the SQL statement parameter.
?>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".btnview").click(function(event) {
		
		event.preventDefault();
		//alert($(this).attr("data"));
		var AMActivityID = $(this).attr("data");
		
	
		 $.post("dataparser.php", {
				method: "getAMActivityDetails",
				amactivityid: AMActivityID
				},
			function(data){
				var output = JSON.parse(data) 
				
				
				console.log(output);
				
				$("#spanactivityid").html(output.AREA_MANAGER_ACTIVITY_ID);
				$("#spanactivitydatetime").html(output.ACTIVITY_DATETIME);
				$("#spanremarks").html(output.REMARKS);
				$("#spanactivitytype").html(output.ACTIVITY_TYPE);
				
				initMap(output.LOCATION_LAT, output.LOCATION_LONG);
			});
	})
	
	
	
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
			<h3>Displaying Activity for <?php echo $_GET["name"];?></h3>
		</div>
	
	
	
		<div class='col-sm-6 right-button-margin'>
		<a href='index.php' class='btn btn-primary pull-right'>
		<span class='glyphicon glyphicon-list-alt'></span> Back to Area Manager List
		</a>
		</div>
			

	</div>

	<div class="row">
		<div class="col-lg-12">

			<div class="row">
				<div class="col-sm-4">
					<table class='table table-hover table-responsive table-bordered'>
						<tr>
							<th>Area Manager Activity ID</th>
							<th>Activity Date Time</th>
							<th>Activity Type</th>
						</tr>
						
						<?php
						while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row); //Import variables into the current symbol table from an array

						echo "<tr>";
						echo "<td>$row[AREA_MANAGER_ACTIVITY_ID]</td>";
						echo "<td>$row[ACTIVITY_DATETIME]</td>";
						echo "<td>$row[ACTIVITY_TYPE]</td>";
						echo "<td>";
						
						// view doctor visit
						echo "<a href='#' data='".$row['AREA_MANAGER_ACTIVITY_ID']."' class=' btnview btn btn-success left-margin'>";
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
								Area Manager Activity ID: <span id="spanactivityid"></span>
							</td>
						</tr>
						<tr>
							<td>
								Activity Date Time:<br />
								<span id="spanactivitydatetime"></span>
							</td>
							<td>
								Activity Type<br />
								<span id="spanactivitytype">
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
					</table>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php
include_once "../footer.php";
?>