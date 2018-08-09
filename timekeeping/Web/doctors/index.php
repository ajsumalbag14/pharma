<?php
$page_title = "Doctors";
$doctors = 'active';

// include database and object files
include_once '../classes/doctors.php';
include_once "../header.php";

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1

// instantiate database and user object
$doctor = new Doctors($db);
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-sm-10"><h3>List of Doctors</h3></div>
					
					<?php if ($_SESSION['USER_TYPE'] == 'Administrator') { ?>
					<div class="col-sm-2 text-right"><a href="create.php" class="btn btn-success"> <i class="fa fa-plus"></i> Add</a></div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>

				<?php

				// select all users
				$prep_state = $doctor->getAllDoctors(); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();

				?>

				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>DOCTOR ID</th>
								<th>LAST NAME</th>
								<th>MIDDLE INITIAL</th>
								<th>FIRST NAME</th>
								<th>DOCTOR SPECIALTY</th>
								<th>ADDRESS 1</th>
								<th>ADDRESS 2</th>
								<th>FREQUENCY</th>
								<th>UNDER AM</th>
								<th>:</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// check if more than 0 record found
						if ($num > 0 ){

							$ctr = 1;
							while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){
								extract($row); //Import variables into the current symbol table from an array
						
								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
										<td>'.$ctr.'</td>
										<td>'.$row['DOCTOR_ID'].'</td>
										<td>'.$row['LAST_NAME'].'</td>
										<td>'.$row['MIDDLE_INITIAL'].'</td>
										<td>'.$row['FIRST_NAME'].'</td>
										<td>'.$row['DOCTOR_SPECIALTY_ID'].'</td>
										<td>'.$row['ADDRESS1'].'</td>
										<td>'.$row['ADDRESS2'].'</td>
										<td>'.$row['FREQUENCY'].'</td>
										<td>'.$row['UNDER'].'</td>
										<td class="center">
										';

										if ($_SESSION['USER_TYPE'] == 'Administrator') {
											echo '
											<a href="edit.php?doctorid='.$row['DOCTOR_ID'].'" class="btn btn-warning left-margin">
											<span class="glyphicon glyphicon-edit"></span> Edit
											</a>';
										}
								echo '
										</td>
									</tr>
								';

								$ctr ++;
							}
						} else {
							
							echo '
								<tr class="odd gradeX">
									<td colspan="5">Records not found.</td>
								</tr>
							';
						}
						?>
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
				
			</div>
			<!-- /.panel -->
			
		</div>
	</div>
</div>


<?php
include_once "../footer.php";
?>