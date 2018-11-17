<?php
	$title = "Add Ingredient";
	$date = "11/23/2016";
	$filename = "add_ingredient.php";
	$banner = "Add Ingredient";
	$description = "This page will serve as a platform for adding ingredients.";
	include("./header_footer/header.php");
	$author = "Sophia Wajdie";




if($_SERVER["REQUEST_METHOD"] == "POST") {

     if (isset($_POST['ingredientSubmit'])) {

        $ingredient_name = trim($_POST["ingredient_name"]);

        $checkSQL =  pg_execute($connect, "ingredientFind", array($ingredient_name));
        $counting = pg_num_rows($checkSQL);



        if($counting == 0) {

            $checkSQL =  pg_execute($connect, "ingredientFindAll", array());
            $counting = pg_num_rows($checkSQL) + 2;

            if (pg_affected_rows(pg_execute($connect, "ingredientInsert", array($counting, $ingredient_name)))) {
                echo '<script language="javascript">';
                echo 'window.addEventListener("load", function(){ alert("Ingredient '.$ingredient_name.' Has Successfully Been Inputted.")});';
                echo '</script>';
            } else {
                echo '<script language="javascript">';
                echo 'window.addEventListener("load", function(){ alert(Ingredient '.$ingredient_name.' Has Not Been Successfully Inputted.")});';
                echo '</script>';
                }
        } else {
            echo '<script language="javascript">';
            echo 'window.addEventListener("load", function(){ alert("'.$ingredient_name.' is already in the database.")});';
            echo '</script>';
        }

    }
}

?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">

	<!-- HEADER -->

		<div class="row">
			<div class="col-sm-12"><h1>Add Ingredient</h1></div>
		</div>

		<form method="post" class="form-horizontal" style="" action=''>

		<br/>

	<!-- FORM -->

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="ingredient_name">Ingredient Name:</label>
			<div class="col-sm-3">
			  <input type="text" class="form-control" id="ingredient_name" name="ingredient_name" required="true">
			</div>
		</div>

	<!-- SUBMIT BUTTON -->

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>
			<div class="col-sm-3" style="">
				<button type="submit" class="btn btn-default" name="ingredientSubmit" style="width:100%;">Submit</button>
			</div>
		</div>
</form>
</div>

<?php
    include("./header_footer/footer.php");
 ?>
