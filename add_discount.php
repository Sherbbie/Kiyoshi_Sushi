<?php
	$title = 'New Discount';
	include("./header_footer/header.php");

  
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
 	if (isset($_POST['addDiscount'])) {
 		$discountCode = trim($_POST["discountCodeInputted"]); 
		$discountProduct = trim($_POST["productID"]); 
		$discountPercent = trim($_POST["percentDiscountAmount"]); 
		$discountPrice = trim($_POST["priceDiscountAmount"]); 
		$discountStart = trim($_POST["dateStart"]); 
		$discountEnd = trim($_POST["dateFinish"]); 
		 
		if($discountProduct == '') {
			$discountProduct = null;
		}
		
		if($discountPrice == '') {
			$discountPrice = null;
		}
		
		if($discountPercent == '') {
			$discountPercent = null;
		}
		
		if($discountEnd == '') {
			$discountEnd = null;
		}
		
		$checkSQL =  pg_execute($connect, "discountCodeLook", array($discountCode));
		 
		$counting = pg_num_rows($checkSQL);
		
		if($counting == 0) {
			if (pg_affected_rows(pg_execute($connect, "discountCodeInsert", array($discountCode, $discountProduct, $discountPercent, $discountPrice, $discountStart, $discountEnd)))) {

			 	echo '<script language="javascript">';
				
				echo 'window.addEventListener("load", function(){ alert("Discount '.$discountCode.' Has Successfully Been Inputted.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Discount '.$discountCode.' Has Not Been Successfully Inputted.")});';
				echo '</script>'; 
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("'.$discountCode.' is Already in Use")});';
			echo '</script>';
		}
		 
		}
		 
	} 

?> 
 

<div class="row">
	<div class="col-sm-12"><h1>New Discount</h1></div>
</div>
<form class="form-horizontal" action='' method='post'>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="discountCode">Discount Code:</label>
    <div class="col-sm-3">
		<input type="text" required autofocus class="form-control" name="discountCodeInputted" id="discountCode">
    </div> 
  </div> 
	
	<div class="form-group">
		<label class=" control-label col-sm-6" style="width:47%;"  for="product">Discounted Product:</label>
		<div class="col-sm-3" >  
			<select class="form-control" name="productID" id="product">
				<option value="">Order Total</option>
					<?php
					$result = pg_query($connect, "SELECT product_id, name FROM tblproducts ORDER BY name ASC");

					while ($row = pg_fetch_assoc($result)) {
						echo '<option value="' . $row['product_id'] . '">'. $row['name'] . '</option>';
					}
					?>
			</select> 
		</div>
  </div> 
	

	<div class="form-group">
		<label class=" control-label col-sm-6" style="width:47%;"  for="typeDiscount">Type of Discount:</label>
		<div class="col-sm-3" >  
				 <select class="form-control" id="discountTypeID" onchange="discountType()">
				  <option value="Percent">Percent</option>
				  <option value="Dollar">Dollar</option> 
				</select>   
		</div>
  </div> 
	
	 <div class="form-group percentAmountSelect">
		<label class=" control-label col-sm-6" style="width:47%;"  for="discountPercent">Percent Amount:</label>
		<div class="col-sm-3" > 
			<div class="input-group">
				<span class="input-group-addon">%</span>
				<input id="discountPercent" name="percentDiscountAmount" type="number" min="0" class="form-control" required max="100" placeholder="Enter Discount Percentage Value"/> 
			</div> 
		</div>
  </div> 
  	
	 <div class="form-group dollarAmountSelect">
		<label class=" control-label col-sm-6" style="width:47%;"  for="discountDollar">Dollar Amount:</label>
		<div class="col-sm-3" > 
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input id="discountDollar" name="priceDiscountAmount"  type="number" step="0.01" min="0" max="1000" class="form-control" placeholder="Enter Discount Dollar Value"/> 
			</div> 
		</div>
  </div> 
	 <div class="form-group">
			<label class=" control-label col-sm-6" style="width:47%;"  for="discountDollar">Discount Start:</label>
			<div class="col-sm-3" >  
			<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					<input  id="datePrice" name="dateStart" type="text" required class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}" oninvalid="this.setCustomValidity('Please Input Date in mm-dd-YYYY Format')" oninput="setCustomValidity('')" /> 
				</div> 
			</div>
	  </div> 
	
  <div class="form-group">
		<label class=" control-label col-sm-6" style="width:47%;"  for="discountDollar">Discount End Date:</label>
		<div class="col-sm-3" >  
		<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				<input  id="datePrice" name="dateFinish" type="text" class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}" oninvalid="this.setCustomValidity('Please Input Date in mm-dd-YYYY Format')" oninput="setCustomValidity('')" /> 
			</div> 
		</div>
  </div> 
	
	<div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default" name="addDiscount">Submit</button>
    </div>
  </div>

</form>
<script> 
		document.getElementById("discountTypeID").addEventListener("load", discountType());
		 
		function discountType() {
			var valueType = document.getElementById('discountTypeID').value; 
			
			if(valueType == "Dollar") {
				 document.getElementById('discountPercent').value = null; 
				$(".dollarAmountSelect").show();
				$(".percentAmountSelect").hide();
				document.getElementById("discountPercent").required = false;
				document.getElementById("discountDollar").required = true;
			} 
			else if(valueType == "Percent") {
				document.getElementById('discountDollar').value = null;
				$(".dollarAmountSelect").hide();
				$(".percentAmountSelect").show();
				document.getElementById("discountPercent").required = true;
				document.getElementById("discountDollar").required = false;
			}
			
		} 
		var dateTimeRetrieve 	= new Date()
		var currentTime 		= dateTimeRetrieve.toLocaleTimeString();

		var currentMonth 		= dateTimeRetrieve.getMonth() + 1
		var currentDay 			= dateTimeRetrieve.getDate()
		var currentYear 		= dateTimeRetrieve.getFullYear()
		var currentDates 		= (currentMonth + "-" + currentDay + "-" + currentYear)

		document.getElementById('datePrice').value =currentDates;
		document.getElementById('timePrice').value =currentTime; 
 
</script>

<?php
	include("./header_footer/footer.php");
 ?>
