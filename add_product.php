<?php
    $title = 'Add Product';
    include 'header_footer/header.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
 	if (isset($_POST['addMarket'])) {
 		$item = trim($_POST["itemName"]); 
		$menuPrice = trim($_POST["itemPrice"]);
		$menuDescription = trim($_POST["itemDescription"]);
		$typeOfProduct = trim($_POST["itemType"]);
		 
		if (isset($_POST['onMenu'])) {
 			$onMenu ='true'; 
		} else {
 			$onMenu ='false';
		}  
		 
		$checkSQL =  pg_execute($connect, "selectProduct", array($item));
		$counting = pg_num_rows($checkSQL) ;
			   
		if($counting == 0) {
 				$checkSQL =  pg_execute($connect, "selectAllProduct", array());
		 
				$counting = pg_num_rows($checkSQL) + 1 ; 
			
				if (pg_affected_rows(pg_execute($connect, "insertProduct", array($counting, $item, $menuPrice, $menuDescription, $onMenu, $typeOfProduct)))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Product Has Successfully Been Inputted.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Product Has Not Been Successfully Inputted.")});';
				echo '</script>'; 
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("Product Has Already Been Inputted.")});';
			echo '</script>';
		}
		 
		}
		 
}


?>
<h1>Add Product</h1>
 <form class="form-horizontal" action='' method='post'>
  <div class="form-group">
    <label class=" control-label col-sm-6" style="width:47%;" for="productName">Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="productName" name="itemName" required placeholder="Enter Product Name">
    </div>
  </div>
	 <div class="form-group">
		<label class=" control-label col-sm-6" style="width:47%;"  for="productName">Menu Price:</label>
		<div class="col-sm-3" > 
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input type="number" step="0.01" min="0" class="form-control" required name="itemPrice" placeholder="Enter Menu Price"/> 
			</div> 
		</div>
  </div> 
  
	 <div class="form-group">
    <label class=" control-label col-sm-6" style="width:47%;" for="productDescription">Description:</label>
    <div class="col-sm-3" >
      <input type="text" class="form-control" id="productDescription" name="itemDescription" required placeholder="Enter Product Description">
    </div>
  </div>

	 <div class="form-group">
    <label class=" control-label col-sm-6" style="width:47%;"  for="selectType">Type of Product:</label>
    <div class="col-sm-3" > 
		  <select required class="form-control" id="selectType" name="itemType">
			<option value=''></option>
			<option value='Appetizer'>Appetizer</option>
 			<option value='Dessert'>Dessert</option>
			<option value='Donburi'>Donburi</option>
 			<option value='Drinks'>Drinks</option>
 			<option value='Makimono À La Carte'>Makimono À La Carte</option> 
			<option value='Makimono Combo'>Makimono Combo</option> 
			<option value='Makimono Roll'>Makimono Roll</option>
			<option value='Nigiri À La Carte'>Nigiri À La Carte</option>   
			<option value='Nigiri Combo'>Nigiri Combo</option>
			<option value='Party Platter'>Party Platter</option>
			<option value='Rainbow of Sushi Combo'>Rainbow of Sushi Combo</option>
			<option value='Sashimi À La Carte'>Sashimi À La Carte</option>  
			<option value='Sashimi Combo'>Sashimi Combo</option>
			<option value='Special Roll'>Special Roll</option>
			<option value='Temaki À La Carte'>Temaki À La Carte</option>  
			<option value='Temaki Combo'>Temaki Combo</option> 
		  </select>
		</div> 
  </div>	
	 
	 <div class="form-group">
    <label class=" control-label col-sm-6" style="width:47%;"  for="productDescription">On Menu:</label>
    <div class="col-sm-1 text-left" style="padding-top: 7px" >
      <input type="checkbox" name="onMenu"> 
    </div>
  </div>	 
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" name='addMarket' class="btn btn-default">Submit</button>
    </div>
  </div>
</form>
<?php include 'header_footer/footer.php';?>