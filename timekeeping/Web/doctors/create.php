<?php

// set page headers
$page_title = "Create Record";
include_once "../header.php";
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<?php
			// read product button
			echo "<div class='right-button-margin'>";
				echo "<a href='index.php' class='btn btn-info pull-right'>";
					echo "<span class='glyphicon glyphicon-list-alt'></span> Read doctors ";
				echo "</a>";
			echo "</div>";

			// get database connection
			include_once '../classes/database.php';
			include_once '../initial.php';

			// check if the form is submitted
			if ($_POST){

				// instantiate user object
				include_once '../classes/doctors.php';
				$doctor = new Doctors($db);
				
				$doctor->firstname = htmlentities(trim($_POST['firstname']));
				$doctor->middleinitial = htmlentities(trim($_POST['middleinitial']));
				$doctor->lastname = htmlentities(trim($_POST['lastname']));
				$doctor->doctorspecialtyid = htmlentities(trim($_POST['doctorspecialtyid']));
				$doctor->address1 = htmlentities(trim($_POST['address1']));
				$doctor->address2 = htmlentities(trim($_POST['address2']));
				$doctor->frequency = $_POST['frequency'];
				$doctor->userid = $_POST['userid'];


				// if the user able to create
				if($doctor->create()){
					
					
					//add record for doctor balance by default
					
					
					
					echo "<div class=\"alert alert-success alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Success! Record is created.";
					echo "</div>";
				}

				// if the record unable to create
				else{
					echo "<div class=\"alert alert-danger alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Error! Unable to create record.";
					echo "</div>";
				}
			}
			?>

			  

			<!-- Bootstrap Form for creating a product -->
			<form action='create.php' role="form" method='post'>

				<table class='table table-hover table-responsive table-bordered'>

					<tr>
						<td>First Name</td>
						<td><input type='text' name='firstname' class='form-control' placeholder="Enter First name" required></td>
					</tr>

					<tr>
						<td>Middle Initial</td>
						<td><input type='text' name='middleinitial' class='form-control' placeholder="Enter Middle Initial"></td>
					</tr>

					<tr>
						<td>Last Name</td>
						<td><input type='text' name='lastname' class='form-control' placeholder="Enter Last Name" required></td>
					</tr>

					<tr>
						<td>Doctor Specialty</td>
						<td><input type='text' name='doctorspecialtyid' class='form-control' placeholder="Enter Doctor Specialty" required></td>
					</tr>
					
					  <tr>
						<td>Address1</td>
						<td><input type='text' name='address1' class='form-control' placeholder="Enter Address 1" required></td>
					</tr>
					
					 <tr>
						<td>Address2</td>
						<td><input type='text' name='address2' class='form-control' placeholder="Enter Address2 "></td>
					</tr>
					
					<tr>
						<td>Frequency</td>
						<td><?php
							for($i=1; $i<7; $i++)
							{
								$checked="";
								if($i == 1)
									$checked="checked";
								else
									$checked="";
								
								echo "<input type='radio' name='frequency' $checked value='$i'>$i ";
							}
							?></td>
					</tr>
					
					<tr>
						<td>User ID</td>
						<td>
						<?php
						
						if($_SESSION["USER_TYPE"] <> "Area Manager") {
						
							// choose parent user id
							include_once '../classes/users.php';

							$users = new Users($db);
							$prep_state = $users->getAllAM();
							echo "<select name='userid' class='form-control'>";

								echo "<option>--- Select User ---</option>";

								while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

									extract($row_category);
									

									echo "<option value='$USER_ID' >$FIRST_NAME $LAST_NAME</option>";
								}
							echo "</select>";
							
						}
						else {
							
							echo "<select name='userid' class='form-control'>";
							echo "<option value=".$_SESSION['USER_ID'].">".$_SESSION["NAME"] ."</option>";
							echo "</select>";

						}	
						?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-plus"></span> Create
							</button>
						</td>
					</tr>

				</table>
			</form>
		</div>
	</div>
</div>
<?php
include_once "../footer.php";
?>

