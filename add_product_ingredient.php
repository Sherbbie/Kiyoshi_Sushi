<?php
	$title = "Add Item Ingredient";
	$date = "11/23/2016";
	$filename = "add_ingredient.php";
	$banner = "Add Ingredient";
	$description = "This page will serve as a platform for adding ingredients.";
	include("./header_footer/header.php");
	$author = "Sophia Wajdie";

if($_SERVER["REQUEST_METHOD"] == "POST") {

 	if (isset($_POST['addIngredientProduct'])) {

 		$productAdd 			= trim($_POST["productAdd"]);
		$ingredient_name 		= trim($_POST["ingredientAdd"]);
		$ingredient_amount 		= trim($_POST["amount_item"]);
		$ingredient_measurement = trim($_POST["measurement"]);


		$checkSQL =  pg_execute($connect, "selectProductIngredient", array($ingredient_name, $productAdd));
		$counting = pg_num_rows($checkSQL) ;

		if($counting == 0) {
			
			if (pg_affected_rows(pg_execute($connect, "createProductIngredient", array($ingredient_name, $productAdd, $ingredient_amount, $ingredient_measurement)))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Has Successfully Been Inputted.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Has Not Been Successfully Inputted.")});';
				echo '</script>';
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("Product Ingredient Has Already Been Inputted.")});';
			echo '</script>';
		}

		}

}
?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">


		<div class="row">
			<div class="col-sm-12"><h1>Add Product Ingredient</h1></div>
		</div>

		<form method="post" class="form-horizontal" style="">

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="productSelect">Product:</label>
				<div class="col-sm-3">
			  		<select class="form-control" name="productAdd" required class="form-control" id="productSelect">
						<option value=""></option>
						<?php
							$result = pg_query($connect, "SELECT*FROM tblproducts ORDER BY name ASC");

							while ($row = pg_fetch_assoc($result)) {
								echo '<option value="' . $row['product_id'] . '">'. $row['name'] . '</option>';
							}
						?>
					</select>
				</div>
			</div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="first_name">Ingredient:</label>
			<div class="col-sm-3">
			  <select class="form-control" name="ingredientAdd" required class="form-control" id="ingredientSelect">
					<option value=""></option>
					<?php
						$result = pg_query($connect, "SELECT*FROM tblingredient ORDER BY ingredient_name ASC");

						while ($row = pg_fetch_assoc($result)) {
								echo '<option value="' . $row['ingredient_id'] . '">'. $row['ingredient_name'] . '</option>';
							}
						?>
				</select>
			</div>
			</div>


		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="amount">Amount:</label>
			<div class="col-sm-3">
			  <input type="number" min='0' class="form-control" id="amount" name="amount_item">
			</div>
			</div>
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="first_name">Unit Measurement:</label>
			<div class="col-sm-3">
				  <select class="form-control" id="selectType" name="measurement">
					<option value=''></option>
					<option value='cup'>Cup</option>
					<option value='deciliter'>Decilitier</option>
					<option value='fluid ounce'>Fluid Ounce</option>
					<option value='gram'>Gram</option>
					<option value='ounce'>Ounce</option>
					<option value='kilogram'>Kilogram</option>
					<option value='liter'>Liter</option>
					<option value='milliliter'>Milliliter</option>
					<option value='pound'>Pound</option>
					<option value='pint'>Pint</option>
					<option value='tablespoon'>Tablespoon</option>
					<option value='teaspoon'>Teaspoon</option>
				  </select>

			</div>
			</div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>
			<div class="col-sm-3">
				<button type="submit" class="btn btn-default" name="addIngredientProduct">Submit</button>
			</div>
		</div>

	</form>
</div>
 <?php
 include("./header_footer/footer.php");
?>
