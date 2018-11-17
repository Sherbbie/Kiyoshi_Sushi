<?php
	$title = "Edit Ingredient";
	$date = "11/2/2016";
	$filename = "edit_ingredient.php";
	$banner = "Edit Ingredient";
	$description = "This page will serve as a platform fot editing ingredients";
	include("./header_footer/header.php");

	if($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['addIngredient'])) {
			$ingredient_name = trim($_POST["ingredient_name"]);
			$ingredient_new = trim($_POST["ingredient_new"]);

			$checkSQL =  pg_execute($connect, "ingredientIDLook", array($ingredient_name));

			$counting = pg_num_rows($checkSQL);

			if($counting != 0) {
				if (pg_affected_rows(pg_execute($connect, "ingredientUpdate", array($ingredient_name, $ingredient_new)))) {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Ingredient '.$ingredient_name.' Has Successfully Been Updated.")});';
					echo '</script>';
				} else {
					echo '<script language="javascript">';
					echo 'window.addEventListener("load", function(){ alert("Ingredient '.$ingredient_name.' Has Not Been Successfully Updated.")});';
					echo '</script>';
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$ingredient_name.' is Already in Use")});';
				echo '</script>';
			}

			}

		}

	?>

<div class="row">
	<div class="col-sm-12"><h1>Edit Ingredient</h1></div>
</div>
<form class="form-horizontal" action='' method='post'>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="ingredient_name">Ingredient Name:</label>
		<div class="col-sm-3">
		<select class="form-control" name="ingredient_name" required class="form-control" id="ingredient_name">
 			<option value=""></option>
			<?php
				$result = pg_query($connect, "SELECT*FROM tblingredient ORDER BY ingredient_name ASC");

				while ($row = pg_fetch_assoc($result)) {
    		echo '<option value="' . $row['ingredient_name'] . '">'. $row['ingredient_name'] . '</option>';
}
?>
		</select>
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="ingredient_new">New Name:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="ingredient_new" name="ingredient_new" required="true" max="100">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default" name="addIngredient">Edit</button>
    </div>
  </div>
</form>

<?php

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET['ingredientname'])) {

 			$ingredientInputted = trim($_GET['ingredientname']);

			$ingredientSQL =  pg_execute($connect, "ingredientSearch", array($ingredientInputted));

			$inputCounting = pg_num_rows($ingredientSQL);

			if($inputCounting != 0) {

				while ($row = pg_fetch_assoc($ingredientSQL))
				{
					?>
						<script>

							document.getElementById('ingredient_name').value = "<?php echo $row['ingredient_name']; ?>";

						</script>
					<?php
					}
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$ingredientInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}
?>


	<script>

		function autofill() {
			var strIngredient = document.getElementById('ingredient_name').value;

			if (strIngredient == '') {
				alert("Please Input A Ingredient Name");
			} else {
					 window.location = "edit_ingredient.php?ingredientname="+strIngredient;

 				}
		}
		</script>

<?php
	include("./header_footer/footer.php");
 ?>
