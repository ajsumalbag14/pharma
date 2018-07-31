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
					echo "<span class='glyphicon glyphicon-list-alt'></span> Read Users ";
				echo "</a>";
			echo "</div>";

			// get database connection
			include_once '../classes/database.php';
			include_once '../initial.php';

			// check if the form is submitted
			if ($_POST){	

				// instantiate user object
				include_once '../classes/users.php';
				$user = new Users($db);

				// set user property values
				$user->firstname = htmlentities(trim($_POST['firstname']));
				$user->middlename = htmlentities(trim($_POST['middlename']));
				$user->lastname = htmlentities(trim($_POST['lastname']));
				$user->usertypeid = $_POST['usertypeid'];
				$user->username = htmlentities(trim($_POST['username']));
				$user->password = md5(htmlentities(trim($_POST['password'])));
				$user->areaid = $_POST['areaid'];
				$user->status = $_POST['status'];
				$user->remarks = htmlentities(trim($_POST['remarks']));
				$user->parentuserid = $_POST['parentuserid'];


				// if the user able to create
				if($user->create()){
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
						<td>Middle Name</td>
						<td><input type='text' name='middlename' class='form-control' placeholder="Enter Middle Name"></td>
					</tr>

					<tr>
						<td>Last Name</td>
						<td><input type='text' name='lastname' class='form-control' placeholder="Enter Last Name" required></td>
					</tr>

					<tr>
						<td>User Type ID</td>
						<td>
							<?php
							// choose user categories
							include_once '../classes/usertypes.php';

							$usertypes = new UserTypes($db);
							$prep_state = $usertypes->getAll();
							echo "<select name='usertypeid' class='form-control'>";

								echo "<option>--- Select User Type ---</option>";

								while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

									extract($row_category);

									echo "<option value='$USER_TYPE_ID'> $USER_TYPE</option>";
								}
							echo "</select>";
						?>
						
						</td>
					</tr>
					
					  <tr>
						<td>Username</td>
						<td><input type='text' name='username' class='form-control' placeholder="Enter Username" required></td>
					</tr>
					
					 <tr>
						<td>Password</td>
						<td><input type='password' name='password' class='form-control' placeholder="Enter Password "></td>
					</tr>
					
					<tr>
						<td>Area ID</td>
						<td>
						
						<?php
							// choose user categories
							include_once '../classes/area.php';

							$area = new Area($db);
							$prep_state = $area->getAll();
							echo "<select name='areaid' class='form-control'>";

								echo "<option>--- Select Area ---</option>";

								while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

									extract($row_category);

									echo "<option value='$AREA_ID'> $AREA_NAME</option>";
								}
							echo "</select>";
						?>			
						
						</td>
					</tr>
					
					<tr>
						<td>Status</td>
						<td>
							<select name='status' class='form-control'>
								<option value="0">Disabled</option>
								<option value="1" selected="selected">Enabled</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td>Remarks</td>
						<td><input type='text' name='remarks' class='form-control' placeholder="Enter Remarks"></td>
					</tr>
					
					<tr>
						<td>Parent User ID</td>
						<td>
							<?php
							// choose parent user id
							include_once '../classes/users.php';

							$user = new Users($db);
							$prep_state = $user->getRecordsExceptAM();
							echo "<select name='parentuserid' class='form-control'>";

								echo "<option>--- Select User ---</option>";

								while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

									extract($row_category);

									echo "<option value='$USER_ID'> $NAME</option>";
								}
							echo "</select>";
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

