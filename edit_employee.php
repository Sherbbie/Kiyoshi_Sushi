<?php
	$title = "Edit Employee";
	$date = "11/23/2016";
	$filename = "edit_employee.php";
	$banner = "Edit Employee";
	$description = "This page will serve as a platform for editing employees";
	include("./header_footer/header.php");
	$author = "Sophia Wajdie";


	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST['editEmployee'])) {

		$user_id =  trim($_POST["user_id"]);
		$position = trim($_POST["position"]);
		$sin_number = trim($_POST["sin_number"]);
		$annual_salary = trim($_POST["annual_salary"]);
		$start_date= trim($_POST["start_date"]);
		$end_date = trim($_POST["end_date"]);
		$admin_privileges = ((int)trim($_POST["admin_privileges"]));

		if($end_date == '') {
					$end_date = null;
				}

			if (pg_affected_rows(pg_execute($connect, "UpdateEmployee", array($user_id, $position, $sin_number, $annual_salary, $start_date, $end_date, $admin_privileges)))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Employee '.$user_id.' Has Successfully Been Updated.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Employee '.$user_id.' Has Not Been Successfully Updated.")});';
				echo '</script>';
				}
		}
	}

?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">

	<!-- EDIT EMPLOYEE HEADER -->

		<div class="row">
			<div class="col-sm-12"><h1>Edit Employee</h1></div>
		</div>

		<form method="post" class="form-horizontal" style="">

		<br/>

	<!-- EDIT EMPLOYEE FORM -->

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="first_name">Employee ID:</label>
			<div class="col-sm-3">
				<select class="form-control" name="user_id" required class="form-control" id="user_id">
				<option value=""></option>
				<?php
					$result = pg_query($connect, "SELECT*FROM tblemployee ORDER BY user_id ASC");

					while ($row = pg_fetch_assoc($result)) {
						echo '<option value="' . $row['user_id'] . '">'. $row['user_id'] . '</option>';
					}
				?>
			</select>
			</div>

			<div class="col-sm-2" style="padding-left: 0px;">
				<button class="btn btn-block btn-default" onclick="autofill()" type="button">Autofill</button>
			</div>

		</div>

	    <div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="position">Position:</label>
			<div class="col-sm-3">
			  <input type="text" class="form-control" id="position" name="position">
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="sin_number">SIN:</label>
			<div class="col-sm-3">
			  <input type="text" class="form-control" id="sin_number" name="sin_number">
			</div>
	    </div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="annual_salary">Annual salary:</label>
			<div class="col-sm-3">
			  <input type="text" class="form-control" id="annual_salary" name="annual_salary">
			</div>
	    </div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="start_date">Start Date:</label>
			<div class="col-sm-3">
			  <input type="date" class="form-control" id="start_date" name="start_date">
			</div>
	    </div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="end_date">End Date:</label>
			<div class="col-sm-3">
			  <input type="date" class="form-control" id="end_date" name="end_date">
			</div>
	    </div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="admin_privileges">Admin Privileges:</label>
			<div class="col-sm-3">
			 <input type="checkbox" class="checkbox" id="admin_privileges" name="admin_privileges">
			</div>
	    </div>

	<!-- SUBMIT BUTTON -->
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>
			<div class="col-sm-3" style="">
				<button type="submit" class="btn btn-default" name="editEmployee" style="width:100%;">Submit</button>
			</div>
		</div>


	<?php

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_GET['user']))
		{

 			$employeeInputted = trim($_GET['user']);

			$employeeSQL =  pg_execute($connect, "searchEmployee", array($employeeInputted));

			$inputCounting = pg_num_rows($employeeSQL);

			if($inputCounting != 0)
			{
				 while ($row = pg_fetch_assoc($employeeSQL))
				{

							echo "<script>";
							echo "document.getElementById('user_id').value = \"". $row['user_id']."\";";

							if ($row['admin_privileges'] == "t")
							{

								echo 'document.getElementById("admin_privileges").checked = true;';
							}

					 		echo "document.getElementById('position').value = \"". $row['position']."\";";
							echo "document.getElementById('sin_number').value = \"". $row['sin_number']."\";";
							echo "document.getElementById('annual_salary').value = \"". $row['annual_salary']."\";";
							echo "document.getElementById('start_date').value = \"". $row['start_date']."\";";
							echo "document.getElementById('end_date').value = \"". $row['end_date']."\";";

							echo "</script>";
				}
			}
			else
			{
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$employeeInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}
	?>

	 <script>

		function autofill() {
			var strEmployee = document.getElementById('user_id').value;

			if (strEmployee == '') {
				alert("Please Input An Employee ID");
			} else {
					 window.location = "edit_employee.php?user="+strEmployee;

 				}
		}

	 </script>
	</form>
</div>

<?php
    include("./header_footer/footer.php");
 ?>
