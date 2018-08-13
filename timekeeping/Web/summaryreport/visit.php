<?php
	$page_title = 'Doctor Visit Summary';
	$summary = 'active';

	include_once "../header.php";
	include_once '../classes/doctorvisitsummary.php';

	// instantiate database and user object
	$visits = new DoctorVisit($db, $_viewAllModules);

	$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : date('Y-m-d', strtotime('previous monday'));
	$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : date('Y-m-d', strtotime('next monday'));

	$date_err = 0;
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Attendance</h3>
					<form name="summaryreport" method="post" action="?">
						<div class='col-sm-12'> 

							Start Date:
							<input type="date" name="startdate" value="<?php echo $startdate?>"/>
							
							End Date:
							<input type="date" name="enddate" value="<?php echo $enddate?>" />

							<input class="btn btn-primary pull-right" type="submit" value="Filter Record" />
							
							
						</div>
					</form>
					<div class="clearfix"></div>
				</div>

				<?php

				$datediff = $visits->getDateDiff($startdate, $enddate);
				$parent_user_id = $_SESSION['USER_ID'];
				
				//filter by 7 days result only
				//if ($datediff >= 0 && $datediff < 8) {
					// select all users
					$param = [
						'user_type_id'			=> $_SESSION['USER_TYPE_ID'],
						'parent_user_id'	=> $parent_user_id,
						'startdate'			=> $startdate,
						'enddate'			=> $enddate,
						'datediff'			=> $datediff
					];

					$prep_state = $visits->getDoctorsVisits($param); //Name of the PHP variable to bind to the SQL statement parameter.
					$num = $prep_state->rowCount();
					$ctr = 1;
				//} else {
				//	$num = 0;
				//	$date_err = 1;
				//}

				?>

				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>DOCTOR VISIT ID</th>
								<th>AREA MANAGER</th>
								<th>DOCTOR</th>
								<th>DATE &amp; TIME</th>
								<th>TOTAL AMOUNT PURCHASED</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// check if more than 0 record found
						if ($num > 0 ){
							while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
										<td>'.$ctr.'</td>
										<td>'.$row['DOCTOR_VISIT_ID'].'</td>
										<td>'.$row['USER'].'</td>
										<td>'.$row['DOCTOR'].'</td>
										<td>'.$row['VISIT_DATETIME'].'</td>
										<td class="center">'.number_format($row['TOTAL'], 2).'</td>
									</tr>
								';

								$ctr ++;
							}
						} else {
							if ($date_err) {
								echo '
									<tr class="odd gradeX">
										<td colspan="5">Date range has reached the limit.</td>
									</tr>
								';
							} else {
								echo '
									<tr class="odd gradeX">
										<td colspan="5">Records not found.</td>
									</tr>
								';
							}
						}
						?>
						</tbody>
					</table>
					<!-- /.table-responsive -->
				</div>
				<!-- /.panel-body -->
				<?php
				if ($num > 0) {
					echo '
						<form action="../export/index.php" method="post">
							<input type="hidden" name="module" value="'.$page_title.'">
							<input type="hidden" name="rpt" value="2">
							<textarea name="query" cols="30" rows="10" style="display:none">
								'.$visits->query_string.'
							</textarea>
							<input type="submit" class="btn btn-primary" value="Export to Excel">
						</form>';
				}
				?>
			</div>
			<!-- /.panel -->
		</div>
	</div>
</div>		
<?php
include_once "../footer.php";
?>