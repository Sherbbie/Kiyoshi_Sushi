<?php ob_start(); ?>
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?php echo $title; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/sushi.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
  		include("includes/db.php");

  			$connect =  connect_database();
  		?>

	<div class="pageInput">
		<nav class="navbar navbar-inverse">
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            	<a class="navbar-brand navbar-left" href="../home.php"><img class="img-responsive"  src="./image/logo.png" alt="Kiyoshi Sushi Logo"></a>
	</div>
	<div id="navbar" class="navbar-collapse collapse">

		  <ul class="nav navbar-nav websiteLocation" >

      <li><a href="../home.php">Home</a></li>
	  <li><a href="../menu.php">Menu</a></li> 
<?php
        if(isset($_SESSION["LoginUserSession"]) == true)
        {
           	$loginData = $_SESSION["LoginUserSession"] ;
            if($loginData["user_type"] == "Customer")
            {
 			  echo "<li><a href=\"../specials.php\">Specials</a></li>";
              echo "<li><a href=\"../edit_customer.php\">Edit My Account</a></li>";
              
            }
            else
            {
				if($loginData["user_type"] == "Admin")
				  {
					echo "<li><a href=\"../admin.php\">Admin Panel</a></li>";
					echo "<li><a href=\"../edit_customer.php\">Edit My Account</a></li>";
				  }	
              // Process Employees
			  echo "<li><a href=\"../order_history.php\">Order History</a></li>";	
              echo "<li><a href=\"../market_prices.php\">Market Prices</a></li>"; 
              
            }
			$loginData = $_SESSION["LoginUserSession"];
			echo "<li><a href=\"../change_password.php\">Change Password</a></li>";
			echo '<li><a href="../contact.php">Contact Us</a></li>';
            echo "<li><a href=\"../logout.php\">Logout</a></li>";
        }
        else
        {
          echo "<li><a href=\"../login.php\">Login</a></li>";
          echo "<li><a href=\"../register.php\">Register</a></li>";
		  echo '<li><a href="../contact.php">Contact Us</a></li>'; 
        }
 			
       ?>  
		  </ul>
	  </div>
		</nav>

	<div class="container-fluid text-center pageBody">
