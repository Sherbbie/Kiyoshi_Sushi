<?php
	$title = "Login";
	$date = "28/10/2016";
	$filename = "login.php";
	$banner = "Login to an existing Account";
	$description = "This page is to serve as a platform for logging into an account for the Kiyoshi Sushi website";
	include("./header_footer/header.php");
?>

<?php
 
if($_SERVER["REQUEST_METHOD"] == "GET"){

$login = "";
$password = "";
$output = "";


}
elseif($_SERVER["REQUEST_METHOD"] == "POST")
{
	
	header("Location: admin.php"); 
			exit();

	$login = trim($_POST["userName"]);
	$password= md5(trim($_POST["userPassword"]));
	$output="";
	
	$result = $loginAttemptQuery;
	
	$result = pg_execute($conn, "LoginAttemptQuery", array($login, $password));
	
	// Check to see if data was found.
	if(pg_fetch_assoc($result))
	{

		setcookie("Login", $login, mktime().time()+60*60*24*30);	
		
		// Set the $result variable to the execution of the prepared SQL statement which pulls all information for the associated user
		$result = pg_execute($conn, "LoginPullUser", array($login));
		
		// Set the sessions based on each index of the pg_fetch_assoc array built upon the data stored in $result**
		$_SESSION["CurrentLoginDataArray"] = pg_fetch_assoc($result);
		// Set login user id Session
		$_SESSION["CurrentLoginId"] = $login;
		
		$currentLoginDataArray = $_SESSION["CurrentLoginDataArray"];
		
		// ESCAPE ---------------------------------------
		if($currentLoginDataArray["user_type"] == DISABLED_USER)
		{
			unset($_SESSION);
			session_destroy();
			session_start();
			$_SESSION["RedirectedOutput"] = "<h2><strong>This account has been disabled due to immense amount of gay head fk u flamingo.</strong></h2> <hr>";
			header("Location: aup.php"); 
		
		}
		
		if($currentLoginDataArray["USER_TYPE"] == CUSTOMER)
		{
		
			$profileCreationQuery = pg_execute($conn, "ProfileCreationQuery", array($currentLoginDataArray["user_id"]));
			
			$_SESSION["CurrentProfileInformationArray"] = pg_fetch_assoc($profileCreationQuery);
			
			header("Location: menu.php"); 
			exit();
		
		}
		
		if($currentLoginDataArray["user_type"] == ADMIN)
		{
		
			$profileCreationQuery = pg_execute($conn, "ProfileCreationQuery", array($currentLoginDataArray["user_id"]));
			
			$_SESSION["CurrentProfileInformationArray"] = pg_fetch_assoc($profileCreationQuery);
			
			header("Location: admin.php"); 
			exit();
		
		}
		
		if($currentLoginDataArray["user_type"] == EMPLOYEE)
		{
		
			$profileCreationQuery = pg_execute($conn, "ProfileCreationQuery", array($currentLoginDataArray["user_id"]));
			
			$_SESSION["CurrentProfileInformationArray"] = pg_fetch_assoc($profileCreationQuery);
			
			header("Location: orderhistory.php"); 
			exit();
		
		}
	
	}
else
{
	$output .= "Login ID and Password incorrect! Please try again";
	$result = $loginPullUser;
	$result = pg_execute($conn, "LoginPullUser", array($login));
	if(!pg_num_rows($result))
	{
			
		$login = "";
			
	}
		
}

$password="";
}
?>
 
<div class="row">
	<div class="col-sm-12"><h1>Login</h1></div>
</div>
<form class="form-horizontal">
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userName">Username:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="userName" placeholder="Enter Username">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userPassword">Password:</label>
    <div class="col-sm-3"> 
      <input type="password" class="form-control" id="userPassword" placeholder="Enter Password">
    </div>
	</div>
  <div class="form-group"> 
    <div class="col-sm-12">
      <button type="submit" name="Log In" value="Log In" class="btn btn-default">Submit</button>
    </div>
  </div>

  <div class="form-group"  style="margin-bottom: 1px;"> 
    <div class="col-sm-12">
       <p><a class="registerPassword" href="./register.php">Register</a></p>
    </div>
  </div> 
  <div class="form-group">
	  <div class="col-sm-6" style="width:47.5%;"></div> 
    <div class="col-sm-2" style="text-align: left;">
       <p><a class="registerPassword" href="./forgotpassword.php">Forgot My Password</a></p> 
    </div>
  </div>	
</form>  

<?php
	include("./header_footer/footer.php");
?>