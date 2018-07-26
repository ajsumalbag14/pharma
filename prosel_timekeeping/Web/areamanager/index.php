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
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>List of Area Managers</h3>
				</div>

				<?php

				// select all users
				$prep_state = $areamanager->getAM($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
				$num = $prep_state->rowCount();

				?>

				<!-- /.panel-heading -->
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>FIRST NAME</th>
								<th>MIDDLE INITIAL</th>
								<th>LAST NAME</th>
								<th>AREA ID</th>
								<th>USERNAME</th>
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
						
								$name = $row['FIRST_NAME'] . ' ' . $row{'LAST_NAME'};

								if ($ctr%2 == 0) {
									echo '<tr class="even gradeX">';
								} else {
									echo '<tr class="odd gradeX">';
								}	

								echo '
										<td>'.$row['FIRST_NAME'].'</td>
										<td>'.$row['MIDDLE_NAME'].'</td>
										<td>'.$row['LAST_NAME'].'</td>
										<td>'.$row['AREA_ID'].'</td>
										<td>'.$row['USERNAME'].'</td>
										<td>'.$row['STATUS'].'</td>
										<td>'.$row['REMARKS'].'</td>
										<td>'.$row['USER_ID'].'</td>
										<td width="300" class="center">
											<a href="amactivity.php?userid='.$row['USER_ID'].'&name='.$name.'" class="btn btn-info left-margin">
												<span class="glyphicon glyphicon-edit"></span> View AM Activity
											</a>

											<a href="doctorvisit.php?userid='.$row['USER_ID'].'&name='.$name.'" class="btn btn-success left-margin">
												<span class="glyphicon glyphicon-edit"></span> Doctor Visit
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