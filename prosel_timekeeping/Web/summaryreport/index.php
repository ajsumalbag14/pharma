<?php
	$page_title = 'Area Manager Attendance Report';
	$summaryam = 'active';

	include_once "../header.php";
	include_once '../classes/areamanagersummary.php';

	// instantiate database and user object
	$areamanager = new AreaManager($db);

	$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : date('Y-m-d', strtotime('previous monday'));
	$enddate = isset($_POST['enddate']) ? $_POST['enddate'] : date('Y-m-d', strtotime('this friday'));
	$typ = isset($_POST['typ']) ? $_POST['typ'] : 'All';
	switch($typ) {
	case 'API_LOGIN':
		$typ1 = ''; $typ2 = 'selected'; $typ3 = '';
		break;
	case 'API_LOGOUT':
		$typ1 = ''; $typ2 = ''; $typ3 = 'selected';
		break;
	default:
		$typ1 = 'selected'; $typ2 = ''; $typ3 = '';
	}

	$date_err = 0;
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>Attendance</h3>
					<form name="summaryreport" method="post" action="index.php">
						<div class='col-sm-12'> 

							Start Date:
							<input type="date" name="startdate" value="<?php echo $startdate?>"/>
							
							End Date:
							<input type="date" name="enddate" value="<?php echo $enddate?>" />

							Type: 
							<select name="typ">
								<option <?php echo $typ1 ?> value="All">All</option>
								<option <?php echo $typ2 ?> value="API_LOGIN">Login</option>
								<option <?php echo $typ3 ?> value="API_LOGOUT">Logout</option>
							</select>

							<input class="btn btn-primary pull-right" type="submit" value="Filter Record" />
							
							
						</div>
					</form>
					<div class="clearfix"></div>
				</div>

				<?php

				$datediff = $areamanager->getDateDiff($startdate, $enddate);
				$parent_user_id = $_SESSION['USER_ID'];
				
				//filter by 7 days result only
				//if ($datediff >= 0 && $datediff < 8) {
					// select all users
					$param = [
						'user_type'			=> $_SESSION['USER_TYPE'],
						'parent_user_id'	=> $parent_user_id,
						'startdate'			=> $startdate,
						'enddate'			=> $enddate,
						'datediff'			=> $datediff,
						'type'				=> isset($_POST['typ']) ? $_POST['typ'] : 'All',
						'area_id'			=> 0,
						'area_manager'		=> 0	
					];

					$prep_state = $areamanager->getAttendance($param); //Name of the PHP variable to bind to the SQL statement parameter.
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
								<th>AREA ID</th>
								<th>AREA MANAGER</th>
								<th>UNDER TO</th>
								<th>DATE TIME</th>
								<th>TYPE</th>
								<th>REMARKS</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// check if more than 0 record found
						if ($num > 0 ){
							while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

								$name = $row["FIRST_NAME"] . " " . $row{"LAST_NAME"};
								$areaid = $row["AREA_ID"];
								$dt = $row["ACTIVITY_DATETIME"];
								$type = str_replace('API_' ,'', $row['ACTIVITY_TYPE']);
								$remarks = $row["REMARKS"];

								$areamanager->getUserName($row['PARENT_USER_ID']);

								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
									<td>'.$ctr.'</td>
									<td>'.$areaid.'</td>
									<td>'.$name.'</td>
									<td>'.$areamanager->parent_name.'</td>
									<td>'.$dt.'</td>
									<td class="center">'.$type.'</td>
									<td width="300" class="center" style="font-size:11px">'.$remarks.'</td>
									</tr>
								';

								$ctr ++;
							}
						} else {
							if ($date_err) {
								echo '
									<tr class="odd gradeX">
										<td colspan="5">Date range has reached the limit. Max date range is seven days only.</td>
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
							<input type="hidden" name="rpt" value="1">
							<textarea name="query" cols="30" rows="10" style="display:none">
								'.$areamanager->query_string.'
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