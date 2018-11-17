<?php
    $title = "Add Employee";
    $date = "11/17/2016";
    $filename = "add_employee.php";
    $banner = "Add Employee";
    include("./header_footer/header.php");


    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $user_id = "";
        $password = "";
        $comfirm_password = "";
        $firstname = "";
        $lastname = "";
        $email = "";
        $sin_number = "";
        $phone = "";
        $address = "";
        $city = "";
        $province = "";
        $postal = "";
        $position = "";
        $annual_salary = "";
        $start_date = "";
        $end_date = "";
        $disabled = false;
        $admin_privileges = false;

        $error_message = "";
        $au = false;
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $user_id = trim($_POST['user_id']);
        $password = trim($_POST['password']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $email = trim($_POST['email']);
        $sin_number = trim($_POST['sin_number']);
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $province = trim($_POST['province']);
        $postal = trim($_POST['postal']);
        $position = trim($_POST['position']);
        $annual_salary = "$";
        $annual_salary .= trim($_POST['annual_salary']);
        $start_date = trim($_POST['start_date']);
        $end_date = trim($_POST['end_date']);
        $disabled = false;
        $admin_privileges = isset($_POST['admin_privileges']);

        $password = md5($password);

		if($end_date == '') {
					$end_date = null;
				}


        $array = array($user_id, $address, $password, $lastname, $firstname, $email, $city, $postal, $province, ((int)$disabled), $phone);

        $employeeArray = array($user_id, $position, $sin_number, $annual_salary, $start_date, $end_date, ((int)$admin_privileges));

        pg_execute($connect, "RegisterUser", $array);

      	pg_execute($connect, "RegisterEmployee", $employeeArray);
 		echo '<script language="javascript">';
                echo 'window.addEventListener("load", function(){ alert("Employee '.$user_id.' has been added")});';
                echo '</script>';
    }
?>

<div class="row">
    <div class="col-sm-12"><h1>Add Employee</h1></div>
</div>
<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="user_id">Username:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" required name="user_id">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="password">Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" required name="password">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="confirm_password">Confirm Password:</label>
    <div class="col-sm-3">
      <input type="password" class="form-control" required name="confirm_password">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="firstname">First Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="firstname" required>
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="lastname">Last Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="lastname" required>
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="email">Email:</label>
    <div class="col-sm-3">
      <input type="email" class="form-control" name="email" required>
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="sin_number">Sin:</label>
    <div class="col-sm-3">
      <input type="number" class="form-control" name="sin_number" required max="999999999">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="phone">Phone:</label>
    <div class="col-sm-3">
      <input type="text" pattern="\d{3}[-]\d{3}[-]\d{4}" class="form-control" name="phone" oninvalid="this.setCustomValidity('Please Input A Phone Number in ###-###-#### Format')" oninput="setCustomValidity('')">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="address">Address:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" required name="address">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="city">City:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" required name="city">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="province">Province:</label>
    <div class="col-sm-3">
		<select name="province" required class="form-control" id="province" required>
			<option value=""></option>
			<option value="Alberta">Alberta</option>
			<option value="British Columbia">British Columbia</option>
			<option value="Manitoba">Manitoba</option>
			<option value="New Brunswick">New Brunswick</option>
			<option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
			<option value="Nova Scotia">Nova Scotia</option>
			<option value="Ontario">Ontario</option>
			<option value="Prince Edward Island">Prince Edward Island</option>
			<option value="Quebec">Quebec</option>
			<option value="Saskatchewan">Saskatchewan</option>
			<option value="Northwest Territories">Northwest Territories</option>
			<option value="Nunavut">Nunavut</option>
			<option value="Yukon">Yukon</option>
		</select>
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="postal">Postal Code:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="postal">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="position">Position:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" name="position">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="annual_salary">Salary:</label>
    <div class="col-sm-3">
      <input type="number" class="form-control" min='0' name="annual_salary" value="">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="start_date">Start Date:</label>
    <div class="col-sm-3">
      <input type="date" class="form-control" name="start_date">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="end_date">End Date:</label>
    <div class="col-sm-3">
      <input type="date" class="form-control" name="end_date">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="admin_privileges">Admin Rights:</label>
    <div class="col-sm-3">
      <input type="checkbox" class="checkbox" name="admin_privileges">
    </div>
  </div>
    <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>

<?php
    include("./header_footer/footer.php");
 ?>
