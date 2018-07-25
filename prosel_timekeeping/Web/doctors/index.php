<?php
$page_title = "Doctors";
$doctors = 'active';

// include database and object files
include_once '../classes/doctors.php';
include_once "../header.php";

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 20; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$doctor = new Doctors($db);
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<?php

			// create user button
			echo "<div class='right-button-margin'>";
			echo "<a href='create.php' class='btn btn-primary pull-right'>";
			echo "<span class='glyphicon glyphicon-plus'></span> Create Record";
			echo "</a>";
			echo "</div>";

			// select all users
			$prep_state = $doctor->getAll($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
			$num = $prep_state->rowCount();

			// check if more than 0 record found
			if($num>=0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
				echo "<tr>";
				//echo "<th>Doctor ID</th>";
				echo "<th>Last Name</th>";
				echo "<th>Middle Initial</th>";
				echo "<th>First Name</th>";
				echo "<th>Doctor Specialty</th>";
				echo "<th>Address 1</th>";
				echo "<th>Address 2</th>";
				echo "<th>Frequency</th>";
				echo "<th>Under AM</th>";
				echo "</tr>";

				while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

					extract($row); //Import variables into the current symbol table from an array

					echo "<tr>";

					//echo "<td>$row[DOCTOR_ID]</td>";
					echo "<td>$row[LAST_NAME]</td>";
					echo "<td>$row[MIDDLE_INITIAL]</td>";
					echo "<td>$row[FIRST_NAME]</td>";
					echo "<td>$row[DOCTOR_SPECIALTY_ID]</td>";
					echo "<td>$row[ADDRESS1]</td>";
					echo "<td>$row[ADDRESS2]</td>";
					echo "<td>$row[FREQUENCY]</td>";
					echo "<td>$row[UNDER]</td>";

			/*        echo "<td>";
								$category->id = $category_id;
								$category->getName();
								echo $category->name;
					echo "</td>";
			*/
					echo "<td>";
					// edit user button
					echo "<a href='edit.php?doctorid=" . $row['DOCTOR_ID'] . "' class='btn btn-warning left-margin'>";
					echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";

					

					echo "</td>";
					echo "</tr>";
				}

				echo "</table>";

				// include pagination file
				include_once 'pagination.php';
			}

			// if there are no user
			else{
				echo "<div> No User found. </div>";
				}
			?>
		</div>
	</div>
</div>


<?php
include_once "../footer.php";
?>