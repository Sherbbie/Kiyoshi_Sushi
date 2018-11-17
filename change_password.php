<?php
	$title = "Change Password";
	$date = "22/11/2016";
	$filename = "changepassword.php";
	$banner = "Change your password";
	$description = "This page is to serve as a platform for changing your password for the Kiyoshi Sushi website";
	include("./header_footer/header.php");
?>



<div class="row">
	<div class="col-sm-12"><h1>Change your password?</h1></div>
</div>

<?php
 
if($_SERVER["REQUEST_METHOD"] == "GET"){

$loginArray = $_SESSION["CurrentLoginDataArray"];
$displayUserID = "<h4><br/>Change your password, ".$loginArray['user_id'];
$user_password = $loginArray['password'];
$password = "";
$new_password = "";
$confirm_password = "";
$error_message = "";

}

else if ($_SERVER['REQUEST_METHOD'] == 'POST')
{

	$loginArray =  $_SESSION["LoginUserSession"];
	$user_password = $loginArray['password'];
	$displayUserID = "<h4><br/>Change your password, ".$loginArray['user_id'];
	$password = trim($_POST['password']);
	$new_password = trim($_POST['newPassword']);
	$confirm_password = trim($_POST['confirmPassword']);
	$error_message = ""; 
 
	$result = pg_execute($connect, "LoginUser", array($loginArray['user_id'], $password));

		// Check to see if data was found.
		if(pg_fetch_assoc($result))
		{ 
			$error_message .= "You entered your current password incorrectly.<br />";
			$password = "";
		}
 
 
	if ($error_message == "")
			{
				$password = $new_password; 
					
				 pg_query($connect, "UPDATE tblusers SET password='".md5($new_password)."' WHERE user_id='".$loginArray['user_id']."'"); 
				echo "
					<script>
						alert('Your password has been change. You will now be signed out');
					</script>
				";				   
				// redirection
				header("Location: logout.php"); 
				exit();
			}
			
	else{
		echo $error_message;
	}
}
 
?>

<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userPassword">Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" name="userPassword" required placeholder="Enter Password">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="newPassword">New Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" name="newPassword" maxlength="20" required placeholder="Enter New Password">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="confirmPassword">Confirm Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" name="confirmPassword" required placeholder="Confirm Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>

<?php
	include("./header_footer/footer.php");
?>