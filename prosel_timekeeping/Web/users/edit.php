<?php
// set page headers
$page_title = "Edit User";
include_once "../header.php";

?>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">


<?php
// read user button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-info pull-right'>";
        echo "<span class='glyphicon glyphicon-list-alt'></span> Read Users ";
    echo "</a>";
echo "</div>";

// isset() is a PHP function used to verify if ID is there or not
$userid = isset($_GET['userid']) ? $_GET['userid'] : die('ERROR! ID not found!');

// include database and object user file
include_once '../classes/database.php';
include_once '../classes/users.php';
include_once '../initial.php';

// instantiate user object
$user = new Users($db);
$user->userid = $userid;
$user->getRecord();

// check if the form is submitted
if($_POST)
{
	
	// set user property values
    $user->firstname = htmlentities(trim($_POST['firstname']));
    $user->middlename = htmlentities(trim($_POST['middlename']));
    $user->lastname = htmlentities(trim($_POST['lastname']));
    $user->usertypeid = $_POST['usertypeid'];
    $user->username = htmlentities(trim($_POST['username']));
	$user->areaid = $_POST['areaid'];
	$user->status = $_POST['status'];
	$user->remarks = htmlentities(trim($_POST['remarks']));
	$user->parentuserid = $_POST['parentuserid'];
	
	//the user wishes to change password of the record
	if(isset($_POST["password"]) || isset($_POST["password2"]))
	{
		//validate first
		$password = md5(htmlentities(trim($_POST["password"])));
		$password2 = md5(htmlentities(trim($_POST["password2"])));
		
		if($password == $password2) 
		{
			//proceed to updating of password
			$user->password = $password;
		}
		else
		{
			echo "Passwords did not match. Please supply a valid password";
			exit;
		}
	}

    // Edit user
    if($user->update()){
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
    <form action='edit.php?userid=<?php echo $userid; ?>' method='post'>

        <table class='table table-hover table-responsive table-bordered'>
		
		 <tr>
            <td>First Name</td>
            <td><input type='text' name='firstname'  value="<?php echo $user->firstname;?>" class='form-control' placeholder="Enter First name" required></td>
        </tr>

        <tr>
            <td>Middle Name</td>
            <td><input type='text' name='middlename'  value="<?php echo $user->middlename;?>" class='form-control' placeholder="Enter Middle Name"></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lastname'  value="<?php echo $user->lastname;?>" class='form-control' placeholder="Enter Last Name" required></td>
        </tr>

        <tr>
            <td>User Type ID</td>
            <td><?php
				// choose user categories
				include_once '../classes/usertypes.php';

				$usertypes = new UserTypes($db);
				$prep_state = $usertypes->getAll();
				echo "<select name='usertypeid' class='form-control'>";

					echo "<option>--- Select User Type ---</option>";

					while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row_category);
						
						$selected = "";
						if($user->usertypeid == $USER_TYPE_ID)
						{
							$selected = "selected='selected'";
						}

						echo "<option value='$USER_TYPE_ID' $selected> $USER_TYPE</option>";
					}
				echo "</select>";
			?></td>
        </tr>
		
		  <tr>
            <td>Username</td>
            <td><input type='text' name='username'  value="<?php echo $user->username;?>" class='form-control' placeholder="Enter Username" required></td>
        </tr>
		
		 <tr>
            <td>Password</td>
            <td>
			If you wish to change password, fill in the password and confirm password textboxes.
			<input type='password' name='password' class='form-control' placeholder="Enter Password "></td>
        </tr>
		
		 <tr>
            <td>Confirm Password</td>
            <td><input type='password' name='password2' class='form-control' placeholder="Enter Password Again"></td>
        </tr>
		
		<tr>
            <td>Area ID</td>
            <td><?php
				// choose user categories
				include_once '../classes/area.php';

				$area = new Area($db);
				$prep_state = $area->getAll();
				echo "<select name='areaid' class='form-control'>";

					echo "<option>--- Select Area ---</option>";

					while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row_category);
						
						$selected = "";
						if($user->areaid == $AREA_ID)
						{
							$selected = "selected='selected'";
						}

						echo "<option value='$AREA_ID' $selected> $AREA_NAME</option>";
					}
				echo "</select>";
			?></td>
        </tr>
		
		<tr>
            <td>Status</td>
			
            <td><select name='status' class='form-control'>
					<option value="0"  <?php echo ($user->status=='0')?'selected="selected"':'' ?>>Disabled</option>
					<option value="1" <?php echo ($user->status=='1')?'selected="selected"':'' ?>>Enabled</option>
				</select></td>
        </tr>
		
		<tr>
            <td>Remarks</td>
            <td><input type='text' name='remarks'  value="<?php echo $user->remarks;?>" class='form-control' placeholder="Enter Remarks"></td>
        </tr>
		
		<tr>
            <td>Parent User ID</td>
            <td><?php
				// choose parent user id
				include_once '../classes/users.php';

				$users = new Users($db);
				$prep_state = $users->getRecordsExceptAM();
				echo "<select name='parentuserid' class='form-control'>";

					echo "<option>--- Select User ---</option>";

					while ($row_category = $prep_state->fetch(PDO::FETCH_ASSOC)){

						extract($row_category);
						
						$selected = "";
						if($user->parentuserid == $USER_ID)
						{
							$selected = "selected='selected'";
						}


						echo "<option value='$USER_ID'$selected> $NAME</option>";
					}
				echo "</select>";
			?></td>
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