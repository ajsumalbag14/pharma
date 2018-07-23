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

				<li class="active">
					<a href="index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				
				<li>
					<a href="users/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Users</span></a>
				</li>
				
				<li>
					<a href="doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
				</li>
				
				<li>
					<a href="Products/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Products</span></a>
				</li>
				
				<li>
					<a href="areamanager/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Area Manager</span></a>
				</li>
				
				<li>
					<a href="doctorvisitreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctor Visit Report</span></a>
				</li>
				
				<li>
					<a href="amactivityreport/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">AM Activity Report</span></a>
				</li>
			
			<?php
			}
			else
			{
			?>
				<li class="active">
					<a href="index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
				</li>
				<li>
					<a href="doctors/index.php"><i class="fa fa-th-large"></i> <span class="nav-label">Doctors</span></a>
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