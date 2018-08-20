<?php
$page_title = "Area Manager Activity Report";
$activity = 'active';

include_once "../header.php";
include_once '../classes/areamanager.php';
$areamanager = new AreaManager($db, $_viewAllModules);
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form name="doctorvisitreport" method="post" action="index.php">
			<div class='col-sm-12'> 

				Select an Area Manager to View: 
				
				<?php
					$prep_state = $areamanager->getListOfAm();
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
			if($_POST)
			{
				//perform some validation of start date and end dates in here
				
				
				// instantiate database and user object
				
				$areamanager->userid = $_POST["userid"];
				// include header file
				
				$startdate = $_POST["startdate"];
				$enddate = $_POST["enddate"];
				
				// select all users
				$prep_state = $areamanager->areaManagerReport($startdate, $enddate); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();


				// check if more than 0 record found
				if($num>=0){
				?>
					<table class='table table-hover table-responsive table-bordered'>
						<tr>
							<th>Area Manager Activity ID</th>
							<th>Area Manager</th>
							<th>Activity Date Time</th>
							<th>Activity Type</th>
							<th>Remarks</th>
						</tr>
						
						<?php
						while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row); //Import variables into the current symbol table from an array

						echo "<tr>";
						echo "<td>$row[AREA_MANAGER_ACTIVITY_ID]</td>";
						echo "<td>$row[USER]</td>";
						echo "<td>$row[ACTIVITY_DATETIME]</td>";
						echo "<td>$row[ACTIVITY_TYPE]</td>";
						echo "<td>$row[REMARKS]</td>";
						echo "<td>";
						
						

						echo "</td>";
						echo "</tr>";
					}
						?>
					</table>

				<?php
				}

				// if there are no user
				else{
					echo "<div> No Record found. </div>";
					}
				
			}
			?>
		</div>
	</div>
</div>
<?php
include_once "../footer.php";
?>