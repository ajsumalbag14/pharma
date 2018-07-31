<?php
$page_title = "Area Manager";
$am = 'active';

// include header file
include_once '../classes/areamanager.php';
include_once "../header.php";

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 20; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$areamanager = new AreaManager($db);
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<?php
			// select all users
			$prep_state = $areamanager->getAM($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
			$num = $prep_state->rowCount();

			// check if more than 0 record found
			if($num>=0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
				echo "<tr>";
				
				echo "<th>First Name</th>";
				echo "<th>Middle Name</th>";
				echo "<th>Last Name</th>";
				echo "<th>Area ID</th>";
				echo "<th>Username</th>";
				echo "<th>Status</th>";
				echo "<th>Remarks</th>";
				echo "<th>Under</th>";
				echo "</tr>";

				while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

					extract($row); //Import variables into the current symbol table from an array

					echo "<tr>";
					
					$name = $row["FIRST_NAME"] . " " . $row{"LAST_NAME"};

					
					echo "<td>$row[FIRST_NAME]</td>";
					echo "<td>$row[MIDDLE_NAME]</td>";
					echo "<td>$row[LAST_NAME]</td>";
					echo "<td>$row[AREA_ID]</td>";
					echo "<td>$row[USERNAME]</td>";
					echo "<td>$row[STATUS]</td>";
					echo "<td>$row[REMARKS]</td>";
					echo "<td>$row[USER_ID]</td>";

					echo "<td>";
					
					// view am activity
					echo "<a href='amactivity.php?userid=" . $row['USER_ID'] . "&name=".$name."' class='btn btn-info left-margin'>";
					echo "<span class='glyphicon glyphicon-edit'></span> View AM Activity";
					echo "</a>";
					
					// view doctor visit
					echo "<a href='doctorvisit.php?userid=" . $row['USER_ID'] . "&name=".$name."' class='btn btn-success left-margin'>";
					echo "<span class='glyphicon glyphicon-edit'></span> Doctor Visit";
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