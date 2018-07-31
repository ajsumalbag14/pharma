<?php

// set page headers
$page_title = "Edit Record";
include_once "../header.php";

$area_id = isset($_POST['id']) ? $_POST['id'] : $_GET['edit_id'] 

?>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<?php
			// read product button
			echo "<div class='right-button-margin'>";
				echo "<a href='index.php' class='btn btn-info pull-right'>";
					echo "<span class='glyphicon glyphicon-list-alt'></span> Back ";
				echo "</a>";
			echo "</div>";

			// get database connection
			include_once '../classes/database.php';
			include_once '../initial.php';
			// instantiate user object
			include_once '../classes/_area.php';
			$area = new Area($db);
			$area->getAreaById($area_id);
			$parent = $area->parent_area_id;

			// check if the form is submitted
			if ($_POST){

				$area->area_name 		= htmlentities(trim($_POST['area_name']));
				$area->area_type_id 	= htmlentities(trim($_POST['area_type']));
				$area->parent_area_id 	= htmlentities(trim($_POST['parent_area']));

				// if the user able to update
				if ($area->edit($area_id)) {
					
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

			<!-- Bootstrap Form for creating a product -->
			<form action='edit.php' role="form" method='post'>
				<input type="hidden" name="id" value="<?php echo $area_id?>">
				<?php
					include_once '../classes/area_type.php';
					$area_type = new AreaType($db);
					$area_type_resource = $area_type->getAll(); 

					//area list
					$area_default_resource = $area->getAll();
				?>
				<table class='table table-hover table-responsive table-bordered'>
					<tr>
						<td>AREA TYPE</td>
						<td>
							<select name="area_type">
								<?php 
									while ($row = $area_type_resource->fetch(PDO::FETCH_ASSOC)) {
										if ($row['AREA_ID'] == $area_id) {
											echo '
												<option selected value="'.$row['AREA_TYPE_ID'].'">'.$row['AREA_TYPE'].'</option>
											';
										} else {
											echo '
												<option value="'.$row['AREA_TYPE_ID'].'">'.$row['AREA_TYPE'].'</option>
											';
										}
									}
								
								?>
							</select>
						</td>
					</tr>

					<tr>
						<td>PARENT AREA</td>
						<td>
							<select name="parent_area">
									<option value="0">No parent</option>
								<?php 
									while ($rs = $area_default_resource->fetch(PDO::FETCH_ASSOC)) {
										if ($rs['AREA_ID'] == $parent) {	
											echo '
												<option selected value="'.$rs['AREA_ID'].'">'.$rs['AREA_NAME'].'</option>
											';
										} else {
											echo '
												<option value="'.$rs['AREA_ID'].'">'.$rs['AREA_NAME'].'</option>
											';
										}
									}
								
								?>
							</select>
						</td>
					</tr>

					<tr>
						<td>AREA NAME</td>
						<td><input type='text' name='area_name' maxlength="50" size="50" placeholder="Enter Area Name"
						value="<?php echo $area->area_name ?>" required></td>
					</tr>

					<tr>
						<td></td>
						<td>
							<button type="submit" class="btn btn-primary">
								<span class="glyphicon glyphicon-plus"></span> Update
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

