<?php

// set page headers
$page_title = "Create Product";
include_once "../header.php";
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
		
			<?php
			// read product button
			echo "<div class='right-button-margin'>";
				echo "<a href='index.php' class='btn btn-info pull-right'>";
					echo "<span class='glyphicon glyphicon-list-alt'></span> Read Products ";
				echo "</a>";
			echo "</div>";

			// get database connection
			include_once '../classes/database.php';
			include_once '../initial.php';

			// check if the form is submitted
			if ($_POST){

				// instantiate user object
				include_once '../classes/products.php';
				$product = new Products($db);

				// set user property values
				$product->productcode = htmlentities(trim($_POST['productcode']));
				$product->productdescription = htmlentities(trim($_POST['productdescription']));
				$product->size = htmlentities(trim($_POST['size']));
				$product->genericnameorpackingshade = htmlentities(trim($_POST['genericnameorpackingshade']));
				//$product->price = htmlentities(trim($_POST['price']));
				//$product->price = "0";
				
				$product->quantity = htmlentities(trim($_POST['quantity']));
				$product->status = $_POST['status'];
				
				if($_SESSION["USER_TYPE"] == "Administrator") {
					$product->price = htmlentities(trim($_POST['price']));
				}
				else
				{
					$product->price = "0";
				}


				// if the user able to create
				if($product->create()){
					echo "<div class=\"alert alert-success alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Success! product is created.";
					echo "</div>";
				}

				// if the product unable to create
				else{
					echo "<div class=\"alert alert-danger alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Error! Unable to create product.";
					echo "</div>";
				}
			}
			?>

			  

			<!-- Bootstrap Form for creating a product -->
			<form action='create.php' role="form" method='post'>

				<table class='table table-hover table-responsive table-bordered'>

					<tr>
						<td>Product Code</td>
						<td><input type='text' name='productcode' class='form-control' placeholder="Enter Product Code" required></td>
					</tr>

					<tr>
						<td>Product Description</td>
						<td><input type='text' name='productdescription' class='form-control' placeholder="Enter Product Description" required></td>
					</tr>

					<tr>
						<td>Size</td>
						<td><input type='text' name='size' class='form-control' placeholder="Enter Size " required></td>
					</tr>

					<tr>
						<td>Generic Name or Packing Shade</td>
						<td><input type='text' name='genericnameorpackingshade' class='form-control' placeholder="Enter Generic Name or Packing Shade" required></td>
					</tr>
					
					<?php 
				
					if($_SESSION["USER_TYPE"] == "Administrator") {
						
						?>
					
						  <tr>
							<td>Price</td>
							<td><input type='number' name='price' class='form-control' value='<?php echo $product->price;?>' placeholder="Enter Price" required></td>
						</tr>
						
						<?php
					}
					
					?>
					
					 <tr>
						<td>Quantity</td>
						<td><input type='number' name='quantity' class='form-control' placeholder="Enter Quantity" required></td>
					</tr>
					
					 <tr>
						<td>Status</td>
						<td>
							<select name="status" class="form-control">
								<option value="1">Enabled</option>
								<option value="0">Disabled</option>
							</select>
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

