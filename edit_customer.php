<?php
	$title = "Edit Account";
	$date = "11/05/2016";
	$filename = "edit_customer.php";
	$banner = "Edit Account";
	$description = "This page will serve as a platform for editing customers";
	include("./header_footer/header.php");
	$author = "Johnathan Martell";
?>
<?php
	if($_SERVER["REQUEST_METHOD"] == "GET")
	{

		$phone = "";
		$email = "";
		$address = "";
		$city = "";
		$postal = "";
		$province = "";


	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$user = array();


		$phone = trim($_POST["phone"]);
		$email = trim($_POST["email"]);
		$address = trim($_POST["address"]);
		$city = trim($_POST["city"]);
		$postal = trim($_POST["postal"]);
		$province = trim($_POST["provSel"]);
		$firstname = trim($_POST["firstname"]);
		$lastname = trim($_POST["lastname"]);

		// Previous VALUES
		$user["user_id"] = $_SESSION["LoginUserSession"]["user_id"];

		// New values
		$user["street_address"] = $address;
		$user["email"] = $email;
		$user["city"] = $city;
		$user["postal_code"] = $postal;
		$user["province"] = $province;
		$user["phone_number"] = $phone;
		$user["first_name"] = $firstname;
		$user["last_name"] = $lastname;

		//$result = pg_execute($connect, "LoginUser", array($login, $password));

		if(pg_execute($connect, "UpdateCustomer", $user))
		{
			$user["user_type"] = $_SESSION["LoginUserSession"]["user_type"];
			$_SESSION["LoginUserSession"] = $user;
			header("Location: home.php");
		}
	}
?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">
	<div class="row">
		<div class="col-sm-12"><h1>Edit Account</h1></div>
	</div>

	<form method="post" class="form-horizontal" style="">
		<br/>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">First Name:</label>
	    <div class="col-sm-3">
	      <input type="first_name" class="form-control" id="firstname" name="firstname">
	    </div>

	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Last Name:</label>
	    <div class="col-sm-3">
	      <input type="last_name" class="form-control" id="lastname" name="lastname">
	    </div>

	  </div>

	  <div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Phone Number:</label>
	    <div class="col-sm-3">
	      <input type="phone_number" class="form-control" id="phone_number" name="phone">
	    </div>

	  </div>
		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="email">Email:</label>
	    <div class="col-sm-3">
	      <input type="email" class="form-control" id="email" name="email">
	    </div>
	  </div>
		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="street_address">Street Address:</label>
	    <div class="col-sm-3">
	      <input type="street_address" class="form-control" id="street_address" name="address">
	    </div>
	  </div>
		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="street_address">City:</label>
	    <div class="col-sm-3">
	      <input type="street_address" class="form-control"name="city">
	    </div>
	  </div>


		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="btn btn-primary dropdown-toggle">Province:</label>
	    <div class="col-sm-6" >
				<div id="provinceselection" class="dropdown" style="text-align: left;">
				  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" name="province" style="width:45.5%;"> <span class="selection">Select your province...</span><span class="caret"></span> </button>
					<input id="selectedProvince" type="hidden" class="form-control" name="provSel">
				  <ul class="dropdown-menu scrollable-menu">
						<p><b>Provinces:</b></p>

						<li><a href="" onclick="return false;">Ontario</a></li>
				    <li><a href="" onclick="return false;">Quebec</a></li>
				    <li><a href="" onclick="return false;">New Brunswick</a></li>
						<li><a href="" onclick="return false;">Nova Scotia</a></li>
				    <li><a href="" onclick="return false;">Manitoba</a></li>
				    <li><a href="" onclick="return false;">Prince Edward Island</a></li>
						<li><a href="" onclick="return false;">British Columbia</a></li>
				    <li><a href="" onclick="return false;">Saskatchewan</a></li>
				    <li><a href="" onclick="return false;">Alberta</a></li>
						<li><a href="" onclick="return false;">Newfoundland and Labrador</a></li>
					</br>
						<p><b>Territories</b></p>
						<li><a href="" onclick="return false;">Northwest Territories</a></li>
				    <li><a href="" onclick="return false;">Yukon</a></li>
				    <li><a href="" onclick="return false;">Nunavut</a></li>

				  </ul>
				</div>
	    </div>
	  </div>


		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="postal_code">Postal Code:</label>
	    <div class="col-sm-3">
	      <input type="postal_code" class="form-control" id="postal_code" name="postal">
	    </div>
	  </div>



		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>


			<div class="col-sm-3" style="">
				<button type="submit" class="btn btn-default" style="width:100%;">Submit</button>
			</div>
		</div>


	</form>
</div>
<script>

$('.dropdown-menu li a').click(function(){
	$(this).parents("#provinceselection").find('.selection').text($(this).text());
	$(this).parents("#provinceselection").find('.selection').val($(this).text());
	var d = document.getElementById("selectedProvince");
	d.value = ($(this).text());
});

</script>
