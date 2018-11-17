<?php
	$title = "Register";
	$date = "28/10/2016";
	$filename = "register.php";
	$banner = "Register a new account";
	$description = "This page is to serve as a platform for logging into an account for the Kiyoshi Sushi website";
	include("./header_footer/header.php");

	// variables

 	if ($_SERVER["REQUEST_METHOD"] == "GET")
 	{
		//When page loads the first time request method will always be GET
		//can be used to make decisions and initialize variables

		$id = "";
		$pass = "";
		$firstname = "";
		$lastname = "";
		$phone = "";
		$email = "";
		$address = "";
		$city = "";
		$province = "";
		$postal = "";
		$disabled = false;

		$error_message = "";
		$au = false;

	}
	else if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$id = trim($_POST['id']);
		$pass = trim($_POST['pass']);
		$firstname = trim($_POST['firstname']);
		$lastname = trim($_POST['lastname']);
		$phone = trim($_POST['phone']);
		$email = trim($_POST['email']);
		$address = trim($_POST['address']);
		$city = trim($_POST['city']);
		$province = trim($_POST["provSel"]);
		$postal = trim($_POST['postal']);
		$disabled = false;

		$pass = md5($pass);

		//pg_execute($connect, "RegisterUser", ));
		$array = array($id, $address, $pass, $lastname, $firstname, $email, $city, $postal, $province, ((int)$disabled), $phone);

		pg_execute($connect, "RegisterUser", $array);

		$customerArray = array($id, $address, $city, $postal, $province, "X", "X");
		pg_execute($connect, "RegisterCustomer", $customerArray);
		header("Location: home.php");
	}


?>


<div class="row" style="width:700px;display: inline-block;">
	<div class="row">
		<div class="col-sm-12"><h1>Register an Account</h1></div>
	</div>

	<form method="post" class="form-horizontal" style="">
		<br/>
	  <div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Username:</label>
	    <div class="col-sm-3">
				<input class="form-control" type="text" name="id" required size="10px" value="" />
	    </div>

	  </div>
		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="email">Password:</label>
	    <div class="col-sm-3">
	      <input class="form-control" id="password" type="password" required name="pass" size="10px" value="" />
	    </div>
	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="email">Confirm Password:</label>
	    <div class="col-sm-3">
	      <input class="form-control" id="passwordconf" disabled="true" required type="password" name="passconf" size="10px" value="" />
	    </div>
	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="street_address">First Name:</label>
	    <div class="col-sm-3">
	      <input class="form-control" type="text" name="firstname" required size="10px" value="" />
	    </div>
	  </div>
		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="street_address">Last Name:</label>
	    <div class="col-sm-3">
	      <input class="form-control" type="text" name="lastname" required size="10px" value="" />
	    </div>
	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Phone Number:</label>
	    <div class="col-sm-3">
				<input class="form-control" type="text" name="phone" required size="10px" value="" />
	    </div>

	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Email:</label>
	    <div class="col-sm-3">
				<input class="form-control" type="text" name="email" required size="10px" value="" />
	    </div>

	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">Street Address:</label>
	    <div class="col-sm-3">
				<input class="form-control" type="text" name="address" required size="10px" value="" />
	    </div>

	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="discount_id">City:</label>
	    <div class="col-sm-3">
				<input class="form-control" type="text" name="city" size="10px" required value="" />
	    </div>

	  </div>

		<div class="form-group">
	    <label class="control-label col-sm-6" style="width:47%;" for="btn btn-primary dropdown-toggle">Province:</label>
	    <div class="col-sm-6" >
				<div id="provinceselection" class="dropdown" style="text-align: left;">
				  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" name="province" style="width:45.5%;"> <span class="selection">Select your province</span>&nbsp;&nbsp;<span class="caret"></span> </button>
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
						<li><a href="" onclick="return false;">Newfoundland</a></li>
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
	      <input type="postal_code" class="form-control" id="postal_code" required name="postal">
	    </div>
	  </div>



		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>


			<div class="col-sm-3" style="">
				<button id="submit" type="submit" disabled="true" class="btn btn-default" style="width:100%;">Submit</button>
			</div>
		</div>


	</form>
</div>

<?php
	include("./header_footer/footer.php");
?>
<script>

var password = "";
var passwordConf = "";
var submit = "";

$('#password').blur(function() {
 password = document.getElementById('password');
 password = password.value;

})

$('#password').bind('input', function() {
	password = document.getElementById('password');
	password = password.value;
	if((password != "" )&&(password.length >= 5))
	{

		passwordConf = document.getElementById('passwordconf');
		passwordConf.disabled = "";
	}
	else {
	 passwordConf = document.getElementById('passwordconf');
	 passwordConf.disabled = "true";
	 $('#passwordconf')[0].value = "";
	}
})

$('#passwordconf').bind('input', function() {

	passwordConf = passwordconf.value;

	if(password == passwordConf)
	{
		submit = $('#submit')[0];
		submit.disabled="";
	}
	else {
		submit = $('#submit')[0];
		submit.disabled="true";
	}
})

$('.dropdown-menu li a').click(function(){
	$(this).parents("#provinceselection").find('.selection').text($(this).text());
	$(this).parents("#provinceselection").find('.selection').val($(this).text());
	var d = document.getElementById("selectedProvince");
	d.value = ($(this).text());
});

</script>
