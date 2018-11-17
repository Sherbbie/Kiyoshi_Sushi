<?php
$title = "Add Supplier";
include("./header_footer/header.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {

     if (isset($_POST['supplierSubmit'])) {

        $firstName = trim($_POST["supplierFirstName"]);
        $lastName = trim($_POST["supplierLastName"]);
        $email = trim($_POST["supplierEmail"]);
        $phone = trim($_POST["supplierPhone"]);

        $checkSQL =  pg_execute($connect, "supplierFind", array($firstName, $lastName, $email));
        
		$counting = pg_num_rows($checkSQL);
		 
        if($counting == 0) {
			 
             $checkAllSupplier         =  pg_execute($connect, "supplierFindAll", array());
             $incrementSupplierID     = pg_num_rows($checkAllSupplier)+1;
            
            if (pg_affected_rows(pg_execute($connect, "supplierInsert", array($incrementSupplierID, $firstName, $lastName, $email, $phone))))
			{
                echo '<script language="javascript">';
                echo 'window.addEventListener("load", function(){ alert("Supplier '.$incrementSupplierID.': '.$firstName.' '.$lastName.' Has Successfully Been Inputted.")});';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'window.addEventListener("load", function(){ alert(Supplier '.$incrementSupplierID.''.$firstName.' '.$lastName.' Has Not Been Successfully Inputted.")});';
                echo '</script>';
                } 
			
        } else {
          echo '<script language="javascript">';
          echo 'window.addEventListener("load", function(){ alert("'.$firstName.' '.$lastName.' with the email '.$email.' is already in the database.")});';
          echo '</script>';
      }
    }
}

?>
<div class="row">
    <div class="col-sm-12"><h1>Add Supplier</h1></div>
</div>
<form class="form-horizontal" action='' method='post'>

    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="firstName">First Name:</label>
    <div class="col-sm-3">
      <input type="text" maxlength="" required class="form-control" name="supplierFirstName" id="firstName">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="lastName">Last Name:</label>
    <div class="col-sm-3">
      <input required type="lName" maxlength="80" class="form-control" name="supplierLastName" id="lastName">
    </div>
  </div>
 <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="emailAddress">Email Address:</label>
    <div class="col-sm-3">
      <input required type="email" maxlength="250" class="form-control" name="supplierEmail" id="emailAddress">
    </div>
  </div>
    <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="phoneNumber">Phone Number:</label>
    <div class="col-sm-3">
      <input required pattern="\d{3}[-]\d{3}[-]\d{4}" type="tel" class="form-control" id="phoneNumber" name="supplierPhone" oninvalid="this.setCustomValidity('Please Input A Phone Number in ###-###-#### Format')" oninput="setCustomValidity('')">
    </div>
  </div>

    <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" name="supplierSubmit" class="btn btn-default">Submit</button>
    </div>
  </div>
</form>

<?php
    include("./header_footer/footer.php");
 ?>
