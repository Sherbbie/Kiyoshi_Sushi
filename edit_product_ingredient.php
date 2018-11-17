<?php
	$title = "Edit Product Ingredient";
	$date = "11/25/2016";
	$filename = "edit_product_ingredient.php";
	$banner = "Edit Product Ingredient";
	$description = "This page will serve as a platform fot editing ingredients";
	include("./header_footer/header.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['editProductIngredient'])) {
			$product_id = trim($_POST["product_id"]);
			$ingredient_id = trim($_POST["ingredient_id"]);
			$amount = trim($_POST["amount"]);
			$unit_measurement = trim($_POST["unit_measurement"]);

			$checkSQL =  pg_execute($connect, "productIngredientIDLook", array($product_id, $ingredient_id));

			$counting = pg_num_rows($checkSQL);

			if($counting != 0) {
				if (pg_affected_rows(pg_execute($connect, "productIngredientUpdate", array($product_id, $ingredient_id, $amount, $unit_measurement)))) {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Product Ingredient '.$product_id.' Has Successfully Been Updated.")});';
					echo '</script>';
				} else {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Product Ingredient '.$product_id.' Has Not Been Successfully Updated.")});';
					echo '</script>';
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$product_id.' is Already in Use")});';
				echo '</script>';
			}

			}

		}

	?>

	<div class="row">
		<div class="col-sm-12"><h1>Edit Product Ingredient</h1></div>
	</div>

	<form method="post" class="form-horizontal" action=''>

	<div class="form-group">
		<label class="control-label col-sm-6" style="width:47%;" for="product_id">Product:</label>
			<div class="col-sm-3">
					<select class="form-control" name="product_id" required class="form-control" id="product_id">
					<option value=""></option>
					<?php
						$result = pg_query($connect, "SELECT*FROM tblproducts ORDER BY name ASC");

						while ($row = pg_fetch_assoc($result)) {
							echo '<option value="' . $row['product_id'] . '">'. $row['name'] . '</option>';
						}
					?>
				</select>
			</div>
			<div class="col-sm-1" style="padding-left: 0px;"><button class="btn btn-block btn-default" onclick="autofill()" type="button">Autofill</button></div>
		</div>

	<div class="form-group">
		<label class="control-label col-sm-6" style="width:47%;" for="ingredient_id">Ingredient:</label>
		<div class="col-sm-3">
			<select class="form-control" name="ingredient_id" required class="form-control" id="ingredient_id">
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
			<input type="number" min='0' class="form-control" id="amount" name="amount">
		</div>
		</div>
	<div class="form-group">
		<label class="control-label col-sm-6" style="width:47%;" for="unit_measurement">Unit Measurement:</label>
		<div class="col-sm-3">
				<select class="form-control" id="unit_measurement" name="unit_measurement">
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
			<button type="submit" class="btn btn-default" name="editProductIngredient">Submit</button>
		</div>
	</div>
</form>

<?php
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET['productingredientid'])) {

 			$productIngredientInputted = trim($_GET['productingredientid']);
			$productInputted = trim($_GET['ingredient']);

			$productIngredientSQL =  pg_execute($connect, "productIngredientSearch", array($productIngredientInputted, $productInputted));

			$inputCounting = pg_num_rows($productIngredientSQL);

			if($inputCounting != 0) {

				while ($row = pg_fetch_assoc($productIngredientSQL))
				{
					?>
						<script>

							document.getElementById('product_id').value = "<?php echo $row['product_id']; ?>";
							document.getElementById('ingredient_id').value = "<?php echo $row['ingredient_id']; ?>";
							document.getElementById('amount').value = "<?php echo $row['amount']; ?>";
							document.getElementById('unit_measurement').value = "<?php echo $row['unit_measurement']; ?>";

						</script>
					<?php
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$productIngredientInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}
?>


	<script>

		function autofill() {

			var strProductIngredient = document.getElementById('product_id').value;
			var strIngredient = document.getElementById('ingredient_id').value;

 			window.location = "edit_product_ingredient.php?productingredientid="+strProductIngredient + "&ingredient="+strIngredient;

		}
		</script>

<?php
	include("./header_footer/footer.php");
 ?>
