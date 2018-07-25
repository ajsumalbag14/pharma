<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu">
			<li class="nav-header">
				<div class="dropdown profile-element">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
					<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $_SESSION["NAME"]; ?></strong>
					 </span> </a>
				   
				</div>
			</li>
			
			<?php
			if($_SESSION["USER_TYPE"] <> "Area Manager") {
				?>

				<li class="<?php echo $index?>">
					<a href="<?php echo $path ?>index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				
				<li class="<?php echo $users?>">
					<a href="<?php echo $path ?>users/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span></a>
				</li>
				
				<li class="<?php echo $doctors?>">
					<a href="<?php echo $path ?>doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
				</li>
				
				<li class="<?php echo $products?>">
					<a href="<?php echo $path ?>products/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Products</span></a>
				</li>
				
				<li class="<?php echo $am?>">
					<a href="<?php echo $path ?>areamanager/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Area Manager</span></a>
				</li>
				
				<li class="<?php echo $visit?>">
					<a href="<?php echo $path ?>doctorvisitreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctor Visit Report</span></a>
				</li>
				
				<li class="<?php echo $activity?>">
					<a href="<?php echo $path ?>amactivityreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">AM Activity Report</span></a>
				</li>

				<li class="<?php echo $summary?>">
					<a href="<?php echo $path ?>summaryreport/index.php"><i class="fa fa-list"></i> <span class="nav-label">AM Summary Report</span></a>
				</li>
				
				
				<?php if ($_SESSION['USER_TYPE'] == 'Administrator') { ?>		
				<li class="<?php echo $areamgmt?>">
					<a href="<?php echo $path ?>area_management/index.php"><i class="fa fa-cog"></i> <span class="nav-label">Area Management</span></a>
				</li>
				<?php } ?>
			
			<?php
			}
			else
			{
			?>
				<li class="<?php echo $index?>">
					<a href="<?php echo $path ?>index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				<li class="<?php echo $doctors?>">
					<a href="<?php echo $path ?>doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
				</li>
			<?php
			}
			?>
			
			<?php
			/*
				
				//user module access is not needed as of the moment because all user types needed to access the available modules. AM cannot access the web
				
				while ($row = $result->fetch(PDO::FETCH_ASSOC)){ 
					extract($row); //Import variables into the current symbol table from an array
				?>
			
					
					<li>
						<a href="<?php echo $row["PAGE_URI"]; ?>"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo $row["MODULE_NAME"]; ?></span></a>
					</li>
				<?php
				}
				
				*/
				?>
			
		</ul>

	</div>
</nav>