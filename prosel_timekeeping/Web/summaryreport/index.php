<?php
$page_title = 'Area Manager Summary Report';
$summary = 'active';

include_once "../header.php";
include_once '../classes/doctorvisit.php';

?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form name="doctorvisitreport" method="post" action="index.php">
			<div class='col-sm-12'> 

				Select an Area Manager to View: 
				
				<?php
					// choose user categories
					include_once '../classes/users.php';

					$user = new Users($db);
					$prep_state = $user->getAllAM();
					echo "<select name='userid'>";

						echo "<option>--- Select Category ---</option>";

						while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

							extract($row_category);

							echo "<option value='$USER_ID'> $FIRST_NAME $LAST_NAME</option>";
						}
					echo "</select>";
				?>

				
				
				Start Date:
				<input type="date" name="startdate" />
				
				End Date:
				<input type="date" name="enddate" />
				
				<input class="btn btn-primary pull-right" type="submit" value="Search Record" />
				
				
			</div>
			</form>
			<?php
				//perform some validation of start date and end dates in here
				
				$doctorvisit = new DoctorVisit($db);
				
				$doctorvisit->userid = isset($_POST["userid"]) ? $_POST["userid"] : 252;
				$startdate = isset($_POST["startdate"]) ? $_POST["startdate"] : '';
				$enddate = isset($_POST["enddate"]) ? $_POST["startdate"] : '';
				
				// select all users
				$prep_state = $doctorvisit->doctorVisitReport($startdate, $enddate); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();

				// check if more than 0 record found
				if($num>=0){

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
						echo "<td>$row[TOTAL]</td>";

						echo "<td>";
						// edit user button
						echo "<a href='am-report.php?doctorvisitid=" . $row['DOCTOR_VISIT_ID'] . "' target='_blank' class='btn btn-info left-margin'>";
						echo "<span class='glyphicon glyphicon-search'></span> Print Preview";
						echo "</a>";

						

						echo "</td>";
						echo "</tr>";
					}

					echo "</table>";

					
				}

				// if there are no user
				else{
					echo "<div> No Record found. </div>";
					}
				
			
			?>
		</div>
	</div>
</div>
<?php
include_once "../footer.php";
?>