<?php
$page_title = "Products";
$products = 'active';

// include header file
include_once '../classes/products.php';
include_once "../header.php";


// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1; // page is the current page, if there's nothing set, default is page 1
$records_per_page = 10; // set records or rows of data per page
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$product = new Products($db);
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="col-sm-10"><h3>List of Products</h3></div>
					
					<?php if ($_SESSION['USER_TYPE'] == 'Administrator') { ?>
					<div class="col-sm-2 text-right"><a href="create.php" class="btn btn-success"> <i class="fa fa-plus"></i> Add</a></div>
					<?php } ?>
					<div class="clearfix"></div>
				</div>

			<?php

			// select all users
			$prep_state = $product->getAll(); //Name of the PHP variable to bind to the SQL statement parameter.
			$num = $prep_state->rowCount();

			?>
				<div class="panel-body">
					<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						<thead>
							<tr>
								<th>#</th>
								<th>PRODUCT CODE</th>
								<th>DESCRIPTION</th>
								<th>SIZE</th>
								<th>GENERIC NAME / PACKING SHADE</th>
								<th>QUANTITY</th>
								<th>STATUS</th>
							</tr>
						</thead>
					<tbody>

					<?php 
					// check if more than 0 record found
					if($num >= 0){
						$ctr = 1;
						while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

							extract($row); //Import variables into the current symbol table from an array

							if ($ctr%2 == 0) {
								echo '<tr class="even gradeX">';
							} else {
								echo '<tr class="odd gradeX">';
							}	

							echo "<td>$row[PRODUCT_CODE]</td>";
							echo "<td>$row[PRODUCT_DESCRIPTION]</td>";
							echo "<td>$row[SIZE]</td>";
							echo "<td>$row[GENERIC_NAME_OR_PACKING_SHADE]</td>";
							echo "<td>$row[QUANTITY]</td>";
							
							$vstat = "";
							if($row["STATUS"] == "0")
								$vstat = "Disabled";
							else if($row["STATUS"] == "1")
								$vstat = "Enabled";
							
							echo "<td>$vstat</td>";
							//echo "<td>$row[DATE_ADDED]</td>";

							if ($_SESSION['USER_TYPE'] == 'Administrator') {
								echo "<td>";
								// edit user button
								echo "<a href='edit.php?productcode=" . $row['PRODUCT_CODE'] . "' class='btn btn-warning left-margin'>";
								echo "<span class='glyphicon glyphicon-edit'></span> Edit";
								echo "</a>";
								echo "</td>";
							}
							echo "</tr>";

							$ctr ++;
						}
					}

					// if there are no user
					else{
						echo "<div> No User found. </div>";
						}
					?>
					</tbody>
				</div> <!-- .panel-body -->
			</div> <!-- .panel -->
		</div>
	</div>	
</div>
<?php
include_once "../footer.php";
?>