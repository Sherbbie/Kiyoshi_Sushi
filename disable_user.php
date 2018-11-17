<?php
	$title = "Disable User";
	$date = "11/23/2016";
	$filename = "disable_user.php";
	$banner = "Disable User";
	$description = "This page will serve as a platform for disabling users";
	include("./header_footer/header.php");
	$author = "Sophia Wajdie";

if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST['addUser'])) {
			
		$user_id = array();
		
		$disable_user = trim($_POST["disable_user"]);

		$user["user_id"] = $_SESSION["LoginUserSession"]["user_id"];

		$checkSQL = pg_execute($connect, "LoginUser", array($login, $password));
		
		$counting = pg_num_rows($checkSQL);

		if($counting != 0) {
			if (pg_affected_rows(pg_execute($connect, "updateUser", array($user, ((int)$disable_user))))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("User '.$user.' Has Successfully Been Updated.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("User '.$user.' Has Not Been Successfully Updated.")});';
				echo '</script>';
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("'.$user.' is Not Found.")});';
			echo '</script>';
		}
	}

}	
	
?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">

	<!-- DISABLE USER HEADER -->
	
		<div class="row">
			<div class="col-sm-12"><h1>Disable User</h1></div>
		</div>

		<form method="post" class="form-horizontal" style="">
	
		<br/>

	<!-- DISABLE USER FORM -->
	
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="user_id">User ID:</label>
			<div class="col-sm-3">
			  <input type="text" class="form-control" id="user_id" name="user_id">
			</div>
		</div>
		
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="disable_user">Disable User:</label>
			<div class="col-sm-3">
			 <input type="checkbox" class="checkbox" id="disable_user" name="disable_user">
			</div>
	    </div>

	<!-- SUBMIT BUTTON -->
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>
			<div class="col-sm-3" style="">
				<button type="submit" class="btn btn-default" style="width:100%;">Submit</button>
			</div>
		</div>
		
	<?php
	
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_GET['user']))
		{
			
 			$userInputted = trim($_GET['user']);
			
			$userSQL =  pg_execute($connect, "searchUser", array($userInputted));

			$inputCounting = pg_num_rows($userSQL);

			if($inputCounting != 0)
			{
				 while ($row = pg_fetch_assoc($userSQL))
				{

							echo "<script>";
							echo "document.getElementById('user_id').value = \"". $row['user_id']."\";";

							if ($row['disable_user'] == "t")
							{
								echo 'document.getElementById("disable_user").checked = true;';
							}
							
							echo "</script>";
				}
			}
			else
			{
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$userInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}
	?>
	
	</form>
</div>

<?php
    include("./header_footer/footer.php");
 ?>