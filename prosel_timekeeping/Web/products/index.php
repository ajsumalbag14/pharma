<?php
$page_title = "Products";

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
			<?php
			// create user button
			echo "<div class='right-button-margin'>";
			echo "<a href='create.php' class='btn btn-primary pull-right'>";
			echo "<span class='glyphicon glyphicon-plus'></span> Create Record";
			echo "</a>";
			echo "</div>";

			// select all users
			$prep_state = $product->getAll($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
			$num = $prep_state->rowCount();

			// check if more than 0 record found
			if($num>=0){

				echo "<table class='table table-hover table-responsive table-bordered'>";
				echo "<tr>";
				echo "<th>Product Code</th>";
				echo "<th>Description</th>";
				echo "<th>Size</th>";
				echo "<th>Generic Name or Packing Shade</th>";
				echo "<th>Quantity</th>";
				echo "<th>Status</th>";
				echo "<th>Date Added</th>";
				echo "</tr>";

				while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

					extract($row); //Import variables into the current symbol table from an array

					echo "<tr>";

					echo "<td>$row[PRODUCT_CODE]</td>";
					echo "<td>$row[PRODUCT_DESCRIPTION]</td>";
					echo "<td>$row[SIZE]</td>";
					echo "<td>$row[GENERIC_NAME_OR_PACKING_SHADE]</td>";
					echo "<td>$row[QUANTITY]</td>";
					echo "<td>$row[STATUS]</td>";
					echo "<td>$row[DATE_ADDED]</td>";

					echo "<td>";
					// edit user button
					echo "<a href='edit.php?productcode=" . $row['PRODUCT_CODE'] . "' class='btn btn-warning left-margin'>";
					echo "<span class='glyphicon glyphicon-edit'></span> Edit";
					echo "</a>";

					

					echo "</td>";
					echo "</tr>";
				}

				echo "</table>";

				// include pagination file
				include_once 'pagination.php';
			}

			// if there are no user
			else{
				echo "<div> No User found. </div>";
				}
			?>
		</div>
	</div>	
</div>
<?php
include_once "../footer.php";
?>