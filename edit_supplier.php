<?php
	$title = "Edit Supplier";
	$date = "10/28/2016";
	$filename = "edit_supplier.php";
	$banner = "Edit Supplier";
	$description = "This page will serve as a platform fot editing suppliers";
	include("./header_footer/header.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['addSupplier'])) {
			$supplier_id = trim($_POST["supplier_id"]);
			$first_name = trim($_POST["first_name"]);
			$last_name = trim($_POST["last_name"]);
			$email = trim($_POST["email"]);
			$phone_number = trim($_POST["phone_number"]);

			$checkSQL =  pg_execute($connect, "supplierIDLook", array($supplier_id));

			$counting = pg_num_rows($checkSQL);

			if($counting != 0) {
				if (pg_affected_rows(pg_execute($connect, "supplierUpdate", array($supplier_id, $first_name, $last_name, $email, $phone_number)))) {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Supplier '.$supplier_id.' Has Successfully Been Updated.")});';
					echo '</script>';
				} else {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Supplier '.$supplier_id.' Has Not Been Successfully Updated.")});';
					echo '</script>';
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$supplier_id.' is Already in Use")});';
				echo '</script>';
			}

			}

		}

	?>
<div class="row">
	<div class="col-sm-12"><h1>Edit Supplier</h1></div>
</div>
<form class="form-horizontal" action='' method='post'>
	<div class="form-group">
	 <label class=" control-label col-sm-6" style="width:47%;" for="supplierSelect">Supplier:</label>
	 <div class="col-sm-3" >
		 <select required class="form-control" name="supplier_id"  id="supplier_id">
			 <option value=""></option>
			 <?php
$result = pg_query($connect, "SELECT*FROM tblsupplier");

while ($row = pg_fetch_assoc($result)) {
	 echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_id'] . '. ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
}
?>
		 </select>
	 </div>
		<div class="col-sm-1" style="padding-left: 0px;"><button class="btn btn-block btn-default" onclick="autofill()" type="button">Autofill</button></div>
  </div>

	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="first_name">First Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="first_name" name="first_name" required="true" max="80">
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="last_name">Last Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="last_name" name="last_name" required="true" max="100">
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="email">Email Address:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="email" name="email" required="true" max="250">
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="phone_number">Phone Number:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="phone_number" name="phone_number" required="true" max="12">
    </div>
  </div>
	<div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default" name="addSupplier">Submit</button>
    </div>
  </div>
</form>

<?php

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET['supplierid'])) {

 			$supplierInputted = trim($_GET['supplierid']);

			$supplierSQL =  pg_execute($connect, "supplierSearch", array($supplierInputted));

			$inputCounting = pg_num_rows($supplierSQL);

			if($inputCounting != 0) {

				while ($row = pg_fetch_assoc($supplierSQL))
				{
					?>
						<script>

							document.getElementById('supplier_id').value = "<?php echo $row['supplier_id']; ?>";
							document.getElementById('first_name').value = "<?php echo $row['first_name']; ?>";
							document.getElementById('last_name').value = "<?php echo $row['last_name']; ?>";
							document.getElementById('email').value = "<?php echo $row['email']; ?>";
							document.getElementById('phone_number').value = "<?php echo $row['phone_number']; ?>";

						</script>
					<?php
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$supplierInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}
?>


	<script>

		function autofill() {
			var strSupplier = document.getElementById('supplier_id').value;

			if (strSupplier == '') {
				alert("Please Input A Supplier ID");
			} else {
					 window.location = "edit_supplier.php?supplierid="+strSupplier;

 				}
		}
		</script>

<?php
	include("./header_footer/footer.php");
 ?>
