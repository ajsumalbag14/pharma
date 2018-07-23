<?php
// set page headers
$page_title = "Edit Product";
include_once "../header.php";
?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<?php
			// read user button
			echo "<div class='right-button-margin'>";
				echo "<a href='index.php' class='btn btn-info pull-right'>";
					echo "<span class='glyphicon glyphicon-list-alt'></span> Read Products ";
				echo "</a>";
			echo "</div>";

			// isset() is a PHP function used to verify if ID is there or not
			$productcode = isset($_GET['productcode']) ? $_GET['productcode'] : die('ERROR! ProductCode not found!');

			// include database and object user file
			include_once '../classes/database.php';
			include_once '../classes/products.php';
			include_once '../initial.php';

			// instantiate user object
			$product = new Products($db);
			$product->productcode = $productcode;
			$product->getRecord();

			// check if the form is submitted
			if($_POST)
			{
				
				$product->productcode = htmlentities(trim($_POST['productcode']));
				$product->productdescription = htmlentities(trim($_POST['productdescription']));
				$product->size = htmlentities(trim($_POST['size']));
				$product->genericnameorpackingshade = htmlentities(trim($_POST['genericnameorpackingshade']));
				$product->price = htmlentities(trim($_POST['price']));
				$product->quantity = htmlentities(trim($_POST['quantity']));
				$product->status = $_POST['status'];


				// Edit user
				if($product->update()){
					echo "<div class=\"alert alert-success alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Success! Record is edited.";
					echo "</div>";
				}

				// if unable to edit user
				else{
					echo "<div class=\"alert alert-danger alert-dismissable\">";
						echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
									&times;
							  </button>";
						echo "Error! Unable to edit record.";
					echo "</div>";
				}
			}
			?>

			<!-- Bootstrap Form for updating a user -->
			<form action='edit.php?productcode=<?php echo $productcode; ?>' method='post'>

				<table class='table table-hover table-responsive table-bordered'>
				
				<tr>
					<td>Product Code</td>
					<td><input type='text' name='productcode' value='<?php echo $product->productcode;?>' class='form-control' placeholder="Enter Product Code" required></td>
				</tr>

				<tr>
					<td>Product Description</td>
					<td><input type='text' name='productdescription' value='<?php echo $product->productdescription;?>' class='form-control' placeholder="Enter Product Description" required></td>
				</tr>

				<tr>
					<td>Size</td>
					<td><input type='text' name='size' class='form-control' value='<?php echo $product->size;?>' placeholder="Enter Size " required></td>
				</tr>

				<tr>
					<td>Generic Name or Packing Shade</td>
					<td><input type='text' name='genericnameorpackingshade' class='form-control' value='<?php echo $product->genericnameorpackingshade;?>' placeholder="Enter Generic Name or Packing Shade" required></td>
				</tr>
				
				  <tr>
					<td>Price</td>
					<td><input type='number' name='price' class='form-control' value='<?php echo $product->price;?>' placeholder="Enter Generic Name or Packing Shade" required></td>
				</tr>
				
				 <tr>
					<td>Quantity</td>
					<td><input type='number' name='quantity' class='form-control' value='<?php echo $product->quantity;?>' placeholder="Enter Generic Name or Packing Shade" required></td>
				</tr>
				
				 <tr>
					<td>Status</td>
					<td>
					<?php
						if($product->status == "1")
						{
							$enabled = "selected='selected'";
							$disabled = "";
						}
						else {
							$enabled = "";
							$disabled = "selected='selected'";
						}
					?>

						<select name="status" class="form-control">
							<option value="1" <?php echo $enabled; ?>>Enabled</option>
							<option value="0" <?php echo $disabled; ?>  >Disabled</option>

						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" class="btn btn-success" >
							<span class=""></span> Update
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