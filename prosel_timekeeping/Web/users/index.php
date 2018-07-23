<?php
$page_title = "Users";

// include database and object files
include_once '../classes/users.php';
include_once "../header.php";

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 20; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$user = new Users($db);

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
				$prep_state = $user->getAll($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();


				// check if more than 0 record found
				if($num>=0){

					echo "<table class='table table-hover table-responsive table-bordered'>";
					echo "<tr>";
					
					echo "<th>Name</th>";
					echo "<th>Area / Coverage</th>";
					echo "<th>User Type</th>";
					echo "<th>Username</th>";
					echo "<th>Status</th>";
					echo "<th>Remarks</th>";
					echo "<th>Under</th>";
					echo "</tr>";

					while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row); //Import variables into the current symbol table from an array

						echo "<tr>";

						
						echo "<td>$row[NAME]</td>";
						echo "<td>$row[AREA_NAME]</td>";
						echo "<td>$row[DESCRIPTION]</td>";
						echo "<td>$row[USERNAME]</td>";
						
						if($row["STATUS"] == "0")
							$status = "Disabled";
						else
							$status = "Enabled";
						
						echo "<td>$status</td>";
						echo "<td>$row[REMARKS]</td>";
						//echo "<td>$row[PARENT_USER_ID]</td>";
						
						echo "<td>";
							$user->parentuserid = $row["PARENT_USER_ID"];
							$user->getName();
							echo $user->firstname . " " . $user->lastname;
						echo "</td>";

						

						echo "<td>";
						// edit user button
						echo "<a href='edit.php?userid=" . $row['USER_ID'] . "' class='btn btn-warning left-margin'>";
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