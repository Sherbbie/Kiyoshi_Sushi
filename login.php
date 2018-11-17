<?php
	$title = "Login";
	$date = "28/10/2016";
	$filename = "login.php";
	$banner = "Login to an existing Account";
	$description = "This page is to serve as a platform for logging into an account for the Kiyoshi Sushi website";
	include("./header_footer/header.php");
?>

<?php

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{

		$login = "";
		$password = "";
		$output = "";


	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$login = trim($_POST["userName"]);
		$password= md5(trim($_POST["userPassword"]));
		$output="";
		$result = $loginUser;
		$result = pg_execute($connect, "LoginUser", array($login, $password));

		// Check to see if data was found.
		if(pg_fetch_assoc($result))
		{

			setcookie("Login", $login, mktime().time()+60*60*24*30);

			$result = pg_execute($connect, "LoginGetUser", array($login));

			$loginData = pg_fetch_assoc($result);
			$loginData["user_type"] = "Blank";

			$userType = "";

			$result = pg_execute($connect, "FindCustomer", array($login));
			$customerData = pg_fetch_assoc($result);
			if($customerData != false) {
				$userType = "Customer";

				if($loginData["disable_user"] == "t")
				{ 
					$userType = "Disabled User";
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Your Account Has Been Disabled.")});';
					echo '</script>'; 
				} else {
					$loginData["user_type"] = $userType;
					$_SESSION["LoginUserSession"] = $loginData;
					header("Location: menu.php");
				}
				$_SESSION["CustomerSession"] = $customerData;
			}
			else
			{
				$employeeResult = pg_execute($connect, "FindEmployee", array($login));

				$employeeData = pg_fetch_assoc($employeeResult);
				if($employeeData != false)
				{
					$userType = "Employee";
					if($employeeData["admin_privileges"])
					{
						$userType = "Admin";
					}

					$_SESSION["EmployeeSession"] = $employeeData;
					$loginData["user_type"] = $userType;
					$_SESSION["LoginUserSession"] = $loginData;
					header("Location: home.php");
				}
			}
			 
		}

		$password="";
}
?>

<div class="row">
	<div class="col-sm-12"><h1>Login</h1></div>
</div>
<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userName">Username:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="userName" placeholder="Enter Username">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="userPassword">Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" name="userPassword" placeholder="Enter Password">
    </div>
	</div>
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Submit</button>
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
       <p><a class="registerPassword" href="./forgot_password.php">Forgot My Password</a></p>
    </div>
  </div>
</form>

<?php
	include("./header_footer/footer.php");
?>
