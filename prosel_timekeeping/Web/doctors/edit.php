<?php
// set page headers
$page_title = "Edit Doctor";
include_once "../header.php";

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">


			<?php

			// read user button
			echo "<div class='right-button-margin'>";
				echo "<a href='index.php' class='btn btn-info pull-right'>";
					echo "<span class='glyphicon glyphicon-list-alt'></span> Read Doctors ";
				echo "</a>";
			echo "</div>";

			// isset() is a PHP function used to verify if ID is there or not
			$doctorid = isset($_GET['doctorid']) ? $_GET['doctorid'] : die('ERROR! ID not found!');

			// include database and object user file
			include_once '../classes/database.php';
			include_once '../classes/doctors.php';
			include_once '../initial.php';

			// instantiate user object
			$doctor = new Doctors($db);
			$doctor->doctorid = $doctorid;
			$doctor->getRecord();

			// check if the form is submitted
			if($_POST)
			{
				
				
				$doctor->firstname = htmlentities(trim($_POST['firstname']));
				$doctor->middleinitial = htmlentities(trim($_POST['middleinitial']));
				$doctor->lastname = htmlentities(trim($_POST['lastname']));
				$doctor->doctorspecialtyid = htmlentities(trim($_POST['doctorspecialtyid']));
				$doctor->address1 = htmlentities(trim($_POST['address1']));
				$doctor->address2 = htmlentities(trim($_POST['address2']));
				$doctor->frequency = $_POST['frequency'];
				$doctor->userid = $_POST['userid'];


				// Edit user
				if($doctor->update()){
					echo "<div class=\"alert alert-success alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Success! Record is edited.";
					echo "</div>";
				}

				// if unable to edit user
				else{
					echo "<div class=\"alert alert-danger alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Error! Unable to edit record.";
					echo "</div>";
				}
			}
			?>

			<!-- Bootstrap Form for updating a user -->
			<form action='edit.php?doctorid=<?php echo $doctorid; ?>' method='post'>

				<table class='table table-hover table-responsive table-bordered'>
				<tr>
					<td>First Name</td>
					<td><input type='text' name='firstname' value="<?php echo $doctor->firstname;?>" class='form-control' placeholder="Enter First name" required></td>
				</tr>

				<tr>
					<td>Middle Initial</td>
					<td><input type='text' name='middleinitial' value="<?php echo $doctor->middleinitial;?>" class='form-control' placeholder="Enter Middle Initial"></td>
				</tr>

				<tr>
					<td>Last Name</td>
					<td><input type='text' name='lastname' value="<?php echo $doctor->lastname;?>" class='form-control' placeholder="Enter Last Name" required></td>
				</tr>

				<tr>
					<td>Doctor Specialty</td>
					<td><input type='text' name='doctorspecialtyid' value="<?php echo $doctor->doctorspecialtyid;?>" class='form-control' placeholder="Enter Doctor Specialty" required></td>
				</tr>
				
				  <tr>
					<td>Address1</td>
					<td><input type='text' name='address1' value="<?php echo $doctor->address1;?>" class='form-control' placeholder="Enter Address 1" required></td>
				</tr>
				
				 <tr>
					<td>Address2</td>
					<td><input type='text' name='address2' value="<?php echo $doctor->address2;?>" class='form-control' placeholder="Enter Address2 "></td>
				</tr>
				
				<tr>
					<td>Frequency</td>
					<td>
						<?php
						for($i=1; $i<7; $i++)
						{
							if($doctor->frequency == $i)
								echo "<input type='radio' name='frequency' checked value='$i'>$i ";
							else
								echo "<input type='radio' name='frequency' value='$i'>$i ";
						}
						?>
					
					</td>
				</tr>
				
				<tr>
					<td>User ID</td>
					<td><?php
					
						if($_SESSION["USER_TYPE"] <> "Area Manager") {
						
							// choose parent user id
							include_once '../classes/users.php';

							$users = new Users($db);
							$prep_state = $users->getAllAM();
							echo "<select name='userid' class='form-control'>";

								echo "<option>--- Select User ---</option>";

								while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

									extract($row_category);
									
									$selected = "";
									if($doctor->userid == $USER_ID)
									{
										$selected = "selected='selected'";
									}

									echo "<option value='$USER_ID' $selected> $FIRST_NAME $LAST_NAME</option>";
								}
							echo "</select>";
						
						}
						else {
							
							echo "<select name='userid' class='form-control'>";
							echo "<option value=".$_SESSION['USER_ID'].">".$_SESSION["NAME"] ."</option>";
							echo "</select>";

						}
					?></td>
				</tr>	

					<tr>
						<td></td>
						<td>
							<button type="submit" class="btn btn-success" >
								<span class=""></span> Update
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
?>;