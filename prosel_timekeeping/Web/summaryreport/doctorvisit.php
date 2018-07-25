<?php
$page_title = "Doctor Visit";

include_once "../header.php";
include_once '../classes/doctorvisit.php';

?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<?php
				//perform some validation of start date and end dates in here
				$doctorvisit = new DoctorVisit($db);
				
				$doctorvisit->userid = $_GET["userid"];
				$visitdate = $_GET["date"];
				
				// select all users
				$prep_state = $doctorvisit->getDoctorsVisitByDate($visitdate); 
				$num = $prep_state->rowCount();

				// check if more than 0 record found
				if ($num > 0) {

					echo "<table class='table table-hover table-responsive table-bordered'>";
					echo "<tr>";
					echo "<th>Doctor Visit Id</th>";
					echo "<th>Area Manager</th>";
					echo "<th>Doctor</th>";
					echo "<th>Visit Date Time</th>";
					echo "<th>Total Amount Purchased</th>";
					echo "<th>&nbsp; </th>";
					
					echo "</tr>";

					while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row); //Import variables into the current symbol table from an array

						echo "<tr>";

						echo "<td>$row[DOCTOR_VISIT_ID]</td>";
						echo "<td>$row[USER]</td>";
						echo "<td>$row[DOCTOR]</td>";
						echo "<td>$row[VISIT_DATETIME]</td>";
						echo "<td>".number_format($row["TOTAL"], 2)."</td>";

						echo "<td>";
						// edit user button
						echo "<a href='../doctorvisitreport/am-report.php?doctorvisitid=" . $row['DOCTOR_VISIT_ID'] . "' target='_blank' class='btn btn-info left-margin'>";
						echo "<span class='glyphicon glyphicon-search'></span> Print Preview";
						echo "</a>";

						

						echo "</td>";
						echo "</tr>";
					}

					echo "</table>";
	
				} else {
					// if there are no user
					echo "<div> No Record found. </div>";
				}
			?>

			
			<h3><a href="index.php" class="btn btn-primary"> Back </a> </h3>
		</div>
	</div>
</div>
<?php
include_once "../footer.php";
?>