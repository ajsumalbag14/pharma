<?php
$page_title = "Users";
$users = 'active';

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
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-sm-10"><h3>List of Users</h3></div>
					<div class="col-sm-2 text-right"><a href="create.php" class="btn btn-success"> <i class="fa fa-plus"></i> Add</a></div>

					<div class="clearfix"></div>
				</div>

				<?php

				// select all users
				$prep_state = $user->getAll($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();

				?>

				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>USERNAME</th>
								<th>NAME</th>
								<th>AREA / COVERAGE</th>
								<th>USER TYPE</th>
								<th>STATUS</th>
								<th>REMARKS</th>
								<th>UNDER</th>
							</tr>
						</thead>
						<tbody>
						<?php 
						// check if more than 0 record found
						if ($num > 0 ){

							$ctr = 1;
							while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){
								extract($row); //Import variables into the current symbol table from an array

								if ($row['STATUS'] == '0') {
									$status = 'Disabled';
								} else {
									$status = 'Enabled';
								}
						
								$user->parentuserid = $row['PARENT_USER_ID'];
								$user->getName();
								$under = $user->firstname . ' ' . $user->lastname;
						
								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
										<td>'.$row['USERNAME'].'</td>
										<td>'.$row['NAME'].'</td>
										<td>'.$row['AREA_NAME'].'</td>
										<td>'.$row['DESCRIPTION'].'</td>
										<td>'.$status.'</td>
										<td>'.$row['REMARKS'].'</td>
										<td>'.$under.'</td>
										<td class="center">
											<a href="edit.php?userid='.$row['USER_ID'].'" class="btn btn-warning left-margin">
											<span class="glyphicon glyphicon-edit"></span> Edit
											</a>
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
