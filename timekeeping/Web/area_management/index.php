<?php
	$page_title = 'Area ID Management';
	$areamgmt = 'active';

	include_once "../header.php";
	include_once '../classes/areamanagement.php';

	// instantiate database and user object
	$area = new Area($db);

?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<?php
			
			if (isset($_GET['disableid']) || isset($_GET['enableid'])){
				$result = false;

				// if the user able to update
				if ($_GET['mode'] == 0) {
					if ($area->disable($_GET['disableid'])) {
						$result = true;
					}
				} else {
					if ($area->enable($_GET['enableid'])) {
						$result = true;
					}
				}
				

				if ($result) {
					//add record for doctor balance by default
					echo "<div class=\"alert alert-success alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Success! Record is updated.";
					echo "</div>";
				} else {
					// if the record unable to create
					echo "<div class=\"alert alert-danger alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Error! Unable to update record.";
					echo "</div>";
				}
			}
			?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-sm-10"><h3>List of Areas Available</h3></div>

					<?php if ($_SESSION['USER_TYPE_ID'] == 14) { ?>
					<div class="col-sm-2 text-right"><a href="create.php" class="btn btn-success"> <i class="fa fa-plus"></i> Add</a></div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>

				<?php

					$prep_state = $area->getAll(); 
					$num = $prep_state->rowCount();
					$ctr = 1;
				
				?>

				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>AREA ID</th>
								<th>NAME</th>
								<th>TYPE</th>
								<th>PARENT AREA ID</th>
								<th>ACTIVE</th>
								<th>:</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// check if more than 0 record found
						if ($num > 0 ){
							while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

								$status = $row['STATUS'] == 1 ? 'Yes' : 'No';

								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
									<td class="center">'.$ctr.'</td>
									<td>'.$row['AREA_ID'].'</td>
									<td>'.$row['AREA_NAME'].'</td>
									<td>'.$row['AREA_TYPE_ID'].'</td>
									<td>'.$row['PARENT_AREA_ID'].'</td>
									<td class="center">'.$status.'</td>
									
									';

								if ($_SESSION['USER_TYPE_ID'] != 14) {	
									echo '<td>';
								}
								else {
									echo '
									<td width="200">
										<a href="edit.php?edit_id='.$row['AREA_ID'].'" class="btn btn-success left-margin">
											<span class="glyphicon glyphicon-edit"></span> Edit
										</a>
									';
										if ($row['STATUS'] == 1) {
											echo '
											<a href="index.php?disableid='.$row['AREA_ID'].'&mode=0" class="btn btn-danger left-margin">
												<span class="glyphicon glyphicon-remove"></span> Disable
											</a>';
										} else {
											echo '
											<a href="index.php?enableid='.$row['AREA_ID'].'&mode=1" class="btn btn-warning left-margin">
												<span class="glyphicon glyphicon-check"></span> Enable
											</a>';
										}
								}
									
									echo '
									</td>
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
										<td colspan="5">Resource not found.</td>
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
			</div>
			<!-- /.panel -->
		</div>
	</div>
</div>		
<?php
include_once "../footer.php";
?>