<?php
	$title = "Forgot Password";
	include("./header_footer/header.php");
?>

<?php

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{

		$login = "";
		$email = "";
		$output = "";

	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$login = trim($_POST["userName"]);
		$email= trim($_POST["userEmail"]);
		$output="";
		$error="";
 
		$checkSQL = pg_execute($connect, "forgotUser", array($login, $email));  
 		$counting = pg_num_rows($checkSQL);
		 
		if($counting != 0){
 
				$newPassword = mt_rand(10000000, 99999999); // generates the 8 digit password for the user
				//echo $newPassword;
				mail($email,RESET_PASSWORD_SUBJECT, "Your new password for Kiyoshi Sushi is ". $newPassword . " you should change this password as soon as posible");
				
				$result = pg_query($connect, "UPDATE tblusers SET password='".md5($newPassword)."' WHERE user_id='$login'");
				// updates the users information the new password
				//note this is being put on the screen because the email function is not enabled and all the test emails have fake emails
				$_SESSION["LogoutMessage"] = "Your password has been changed and Emailed to you " . $newPassword;
				header("Location: login.php");
			}
			else{
				
				echo "<script>
						alert('$login $email $counting');
						</script>";
	
			}
		}
			 
?>

<div class="row">
	<div class="col-sm-12"><h1>Forgot your password?</h1></div>
</div>
<form class="form-horizontal" method="post" action="">
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userName">Username:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="userName" placeholder="Enter Username">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userEmail">Email:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="userEmail" placeholder="Enter Email">
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