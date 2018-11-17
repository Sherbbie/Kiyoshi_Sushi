<?php
	$title = "Edit Product";
	$date = "10/28/2016";
	$filename = "edit_product.php";
	$banner = "Edit Product";
	include("./header_footer/header.php");


if($_SERVER["REQUEST_METHOD"] == "POST")
{

	if (isset($_POST['addProduct'])) {
		$name = trim($_POST["name"]);
		$price = trim($_POST["price"]);
		$description = trim($_POST["description"]);
		$type = trim($_POST["type"]);
		$on_menu = isset($_POST['on_menu']);

		$checkSQL =  pg_execute($connect, "productIDLook", array($name));

		$counting = pg_num_rows($checkSQL);

		if($counting != 0) {
			if (pg_affected_rows(pg_execute($connect, "productUpdate", array($name, $price, $description, ((int)$on_menu), $type)))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Product '.$name.' Has Successfully Been Updated.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Product '.$name.' Has Not Been Successfully Updated.")});';
				echo '</script>';
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("'.$name.' is Already in Use")});';
			echo '</script>';
		}

		}

}
?>

<div class="row">
	<div class="col-sm-12"><h1>Edit Product</h1></div>
</div>
<form class="form-horizontal" action='' method='post'>
  <div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="name">Product Name:</label>
    <div class="col-sm-3">
			<select class="form-control" name="name" required class="form-control" id="name">
			<option value=""></option>
			<?php
				$result = pg_query($connect, "SELECT*FROM tblproducts ORDER BY name ASC");

				while ($row = pg_fetch_assoc($result)) {
					echo '<option value="' . $row['name'] . '">'. $row['name'] . '</option>';
				}
			?>
		</select>
    </div>
		<div class="col-sm-1" style="padding-left: 0px;"><button class="btn btn-block btn-default" onclick="autofill()" type="button">Autofill</button></div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="price">Price:</label>
    <div class="col-sm-3">
      <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required="true">
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="description">Description:</label>
    <div class="col-sm-3">
      <input type="text" class="form-control" id="description" name="description" required="true" max="100">
    </div>
  </div>
	<div class="form-group">
    <label class="control-label col-sm-6" style="width:47%;" for="on_menu">On Menu:</label>
    <div class="col-sm-3">
      <input type="checkbox" class="checkbox" id="on_menu" name="on_menu">
    </div>
  </div>
	<div class="form-group">
		<label class=" control-label col-sm-6" style="width:47%;"  for="type">Type:</label>
		<div class="col-sm-3" >
			<select required class="form-control" id="type" name="type" required="true">
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
    <div class="col-sm-12">
      <button type="submit" class="btn btn-default" name="addProduct">Submit</button>
    </div>
  </div>
</form>

<?php

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		if (isset($_GET['name']))
		{

 			$productInputted = trim($_GET['name']);

			$productSQL =  pg_execute($connect, "productSearch", array($productInputted));

			$inputCounting = pg_num_rows($productSQL);

			if($inputCounting != 0)
			{

				while ($row = pg_fetch_assoc($productSQL))
				{

							echo "<script>";
							echo "document.getElementById('name').value = \"". $row['name']."\";";
							echo "document.getElementById('price').value = \"".$row['price']."\";";
							echo "document.getElementById('description').value = \"".$row['description']."\";";

							if ($row['on_menu'] == "t")
							{

								echo 'document.getElementById("on_menu").checked = true;';
							}

							echo "document.getElementById('type').value = \"". $row['type']."\"";
							echo "</script>";
				}
			}
			else
			{
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("'.$productInputted.' does not exist")});';
				echo '</script>';
			}

		}
	}

?>

	 <script>

		function autofill() {
			var strProduct = document.getElementById('name').value;

			if (strProduct == '') {
				alert("Please Input A Product Name");
			} else {
					 window.location = "edit_product.php?name="+strProduct;

 				}
		}
		</script>

	<?php
		include("./header_footer/footer.php");
	 ?>
