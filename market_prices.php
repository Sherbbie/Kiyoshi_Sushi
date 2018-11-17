<?php
$title = 'Market Prices';
include("./header_footer/header.php"); 
  
if($_SERVER["REQUEST_METHOD"] == "POST") {
	
 	if (isset($_POST['addMarket'])) {
 		$ingredientMarket = trim($_POST["ingredient"]);
		$dateTimeMarket = trim($_POST["date"]).' '.trim($_POST["time"]);	
		$supplierMarket = trim($_POST["supplierID"]);
		$priceMarket = trim($_POST["marketPrice"]);
		
		$checkSQL =  pg_execute($connect, "selectMarketSupp", array($ingredientMarket, $dateTimeMarket, $supplierMarket));
		 
		$counting = pg_num_rows($checkSQL);
		
		if($counting == 0) {
				if (pg_affected_rows(pg_execute($connect, "NewMarket", array($ingredientMarket, $dateTimeMarket, $supplierMarket, $priceMarket)))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Market Price Has Successfully Been Inputted.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Market Price Has Not Been Successfully Inputted.")});';
				echo '</script>'; 
				}
		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("Ingredient Market Price Has Already Been Inputted.")});';
			echo '</script>';
		}
		 
		}
		  
    elseif (isset($_POST['deleteMarket'])) {
        $ingredientRemove 		= trim($_POST["ingredientRemove"]);
		$dateTimeRemove 		= trim($_POST["date"]).' '.trim($_POST["timeRemove"]);	 
		$supplierRemoveMarket 	= trim($_POST["supplierIDRemove"]);
		
		$checkSQL =  pg_execute($connect, "selectMarketSupp", array($ingredientRemove, $dateTimeRemove, $supplierRemoveMarket));
		 
		$counting = pg_num_rows($checkSQL); 
		
		if($counting != 0) {
			if (pg_execute($connect, "removeMarket", array($ingredientRemove, $dateTimeRemove, $supplierRemoveMarket))) {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Has Been Removed.")});';
				echo '</script>';
			} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Ingredient Has Not Been Successfully Removed.")});';
				echo '</script>'; 
			}

		} else {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("Ingredient Market Price Was Not Found.")});';
			echo '</script>';
		}
		 
    }
		 
} 
?>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<div class="row">
	<div class="col-sm-12"><h1>Market Prices</h1></div>
</div>
<div class="row">
<form class="form-horizontal col-sm-5" action='' method='post' >
	
 <div class="form-group">
    <h2 class="control-label col-sm-12" >Add Ingredient Price</h2>
  </div> 
	
  <div class="form-group">
    <label class="control-label col-sm-8"  for="ingredient">Ingredient:</label>
    <div class="col-sm-4"> 
		<select class="form-control" name="ingredient" required class="form-control" id="ingredientSelect">
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
		<label class=" control-label col-sm-8" for="supplierSelect">Supplier:</label>
		<div class="col-sm-4" > 
			<select required class="form-control" name="supplierID"  id="supplierSelect">
 				<option value=""></option>
				<?php
$result = pg_query($connect, "SELECT*FROM tblsupplier");

while ($row = pg_fetch_assoc($result)) {
    echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_id'] . '. ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
}
?>
			</select>
		</div>
  </div> 
  	
	 <div class="form-group">
		<label class=" control-label col-sm-8" for="price">Price:</label>
		<div class="col-sm-4" > 
			<div class="input-group">
				<span class="input-group-addon">$</span>
				<input id="discountDollar" required type="number" name="marketPrice" required step="0.01" min="0" class="form-control" placeholder="Enter Price"/> 
			</div> 
		</div>
  </div> 
	 
 <div class="form-group">
		<label class=" control-label col-sm-8" for="datePrice">Date:</label>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				<input  id="datePrice" name="date" type="text" required class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}" oninvalid="this.setCustomValidity('Please Input Date in mm-dd-YYYY Format')" oninput="setCustomValidity('')" /> 
			</div> 
		</div> 
  </div> 
	
	 <div class="form-group">
		<label class=" control-label col-sm-8" for="datePrice">Time:</label>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span> 
				<input required  id="timePrice" name="time" type="time" pattern="^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9]\s*[aApP][mM]\s*$" required class="form-control" oninvalid="this.setCustomValidity('Please Input Time in HH:mm:ss AM/PM Format')" oninput="setCustomValidity('')" />
			</div> 
		</div> 
  </div> 

	
		 <div class="form-group">
		<div class="control-label col-sm-8"  ></div>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<button type="submit" class="btn btn-default" name="addMarket" value="submitDiscount">Submit</button>
			</div> 
		</div> 
  </div> 
 
	
	
	
</form> 
<div class="col-sm-2"></div>
<form class="form-horizontal col-sm-5" action='' method='post' >
	
 <div class="form-group text-left" style="padding-left: 18px; padding-top: 7px; ">
    <h2>Remove Ingredient Price</h2>
  </div> 
	
  <div class="form-group">
    <label class="control-label col-sm-2"  for="ingredient">Ingredient:</label>
    <div class="col-sm-4"> 
		<select class="form-control" name="ingredientRemove" required class="form-control" id="ingredientSelect">
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
		<label class=" control-label  col-sm-2" for="supplierSelect">Supplier:</label>
		<div class="col-sm-4" > 
 			<select required class="form-control" name="supplierIDRemove" class="form-control" id="supplierSelect">
				<option value=""></option>
				<?php
				$result = pg_query($connect, "SELECT*FROM tblsupplier");
				
				while ($row = pg_fetch_assoc($result)) {
					echo '<option value="' . $row['supplier_id'] . '">' . $row['supplier_id'] . '. ' . $row['first_name'] . ' ' . $row['last_name'] . '</option>';
				}
				?>
 			</select>
		</div>
		</div> 
	
 <div class="form-group">
		<label class=" control-label col-sm-2"   for="datePrice">Date:</label>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				<input  id="datePrice" name="date" type="text" required class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}" oninvalid="this.setCustomValidity('Please Input Date in mm-dd-YYYY Format')" oninput="setCustomValidity('')" /> 
			</div> 
		</div> 
  </div> 
	
	 <div class="form-group">
		<label class=" control-label col-sm-2"   for="datePrice">Time:</label>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span> 
				<input required  id="timePrice" name="timeRemove" type="time" pattern="^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9]\s*[aApP][mM]\s*$" required class="form-control" oninvalid="this.setCustomValidity('Please Input Time in HH:mm:ss AM/PM Format')" oninput="setCustomValidity('')" />
			</div> 
		</div> 
  </div> 
	

		 <div class="form-group">
		<div class="control-label col-sm-2"  ></div>
		<div class="col-sm-4" >  
 			<div class="input-group">
				<button type="submit" class="btn btn-primary" name="deleteMarket" value="submitDiscount">Submit</button>
			</div> 
		</div> 
  </div> 
  
</form> 
</div>
 
<div class="container-fluid" style="background-color: white;">
  <div class="row">
    <div class="col-sm-12">
      <div class="showcase__section" id="bubble">
		  <div class="spacer --small"></div>
		  <div id="bubbleplots">
			<div class="bubbleplot" data-num="0">
			  <div class="plot" id="graphIngredientPrice"></div>
			  <div class="control-row" style=" padding-bottom: 5px;" >
					Ingredient: <select class="ingredientDropdownSelect">
				</select>
			  </div>
			</div>
		  </div>
		</div>
    </div> 
  </div> 
</div>
  <div style="height: 15px;"></div>
<script>  
		var dateTimeRetrieve = 	new Date()
		var currentTime = dateTimeRetrieve.toLocaleTimeString();

		var currentMonth = dateTimeRetrieve.getMonth() + 1
		var currentDay = dateTimeRetrieve.getDate()
		var currentYear = dateTimeRetrieve.getFullYear()
		var currentDates = (currentMonth + "-" + currentDay + "-" + currentYear)

		document.getElementById('datePrice').value =currentDates;
		 document.getElementById('timePrice').value =currentTime; 
	
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); 
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'mm-dd-yyyy', 
            todayHighlight: true,
            autoclose: true,  
        })
    })
	 
      Plotly.d3.csv('', function(err, rows){
 
	var ingredientsTable = [
	<?php
	$result = pg_query($connect, "SELECT ingredient_name, ingredient_id FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY ingredient_name, date_time_added ASC;");

	while ($row = pg_fetch_assoc($result)) {
		echo '"' . $row['ingredient_name'] . '",';
	}
	?>],
		datetimePrice = [
	<?php
	$result = pg_query($connect, "SELECT date_time_added FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY  ingredient_name, date_time_added ASC;");

	while ($row = pg_fetch_assoc($result)) {
		echo '"' . $row['date_time_added'] . '",';
	}
	?>],
		ingredientPrice = [
	<?php
	$result = pg_query($connect, "SELECT market_price FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY  ingredient_name, date_time_added ASC;");

	while ($row = pg_fetch_assoc($result)) {
		echo '"' . $row['market_price'] . '",';
	}
	?>],
	 datetimePrice = [
	<?php
	$result = pg_query($connect, "SELECT date_time_added FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY  ingredient_name, date_time_added ASC;");

	while ($row = pg_fetch_assoc($result)) {
		echo '"' . $row['date_time_added'] . '",';
	}
	?>],
		supplierName = [
	<?php
	$result = pg_query($connect, "SELECT supplier_id FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY  ingredient_name, date_time_added ASC;");

	while ($row = pg_fetch_assoc($result)) {
		echo '"Supplier ID: ' . $row['supplier_id'] . '",';
	}
	?>],

		allIngredients = [],
		selectedIngredient,
		priceForDateIngredient = [],
		priceIngredientDateTime = [];

	  for (var indexCount = 0; indexCount < ingredientsTable.length; indexCount++ ){
		if (allIngredients.indexOf(ingredientsTable[indexCount]) === -1 ){
		  allIngredients.push(ingredientsTable[indexCount]);
		}
	  }

	  function ingredientPriceGetData(ingredientUserSelected) {
		priceCurrentIngredient = [];
		priceIngredientDateTime = [];
		for (var indexCount = 0 ; indexCount < ingredientsTable.length ; indexCount++){
		  if ( ingredientsTable[indexCount] === ingredientUserSelected ) {
			priceCurrentIngredient.push(ingredientPrice[indexCount]);
			priceIngredientDateTime.push(datetimePrice[indexCount]);
		  } 
		}
	  };

	// Default Country Data
	setBubblePlot(
		<?php
	$result = pg_query($connect, "SELECT DISTINCT ingredient_name, ingredient_id FROM tblingredientprice NATURAL JOIN tblingredient ORDER BY ingredient_name ASC LIMIT 1;");

	while ($row = pg_fetch_assoc($result)) {
		echo "'" . $row['ingredient_name'] . "'";
	}
	?>);

	function setBubblePlot(ingredientUserSelected) {
		ingredientPriceGetData(ingredientUserSelected);  

		var lineGraph = {
		  x: priceIngredientDateTime,
		  y: priceCurrentIngredient, 
		  text: supplierName, 
		  mode: 'lines+markers',
		  marker: {
			size: 10, 
			opacity: 0.75
		  }
		};

		var dataForGraph = [lineGraph];

		var layout = { 
			title: ingredientUserSelected + ' Market Price Trends',
			hovermode:'closest',
			autosize: false,
			width: $(window).width()-62,
			height: 500,
			margin: {
				l: 50,
				r: 50, 
				pad: 4
			  },
		};

		Plotly.newPlot('graphIngredientPrice', dataForGraph, layout, {scrollZoom: true});
	};

	var containerValues = document.querySelector('[data-num="0"'),
		graphPlots = containerValues.querySelector('.plot'),
		ingredientDropdown = containerValues.querySelector('.ingredientDropdownSelect');

	function createOptions(selectIngredientNames, buildSelector) {
	  for (var i = 0; i < selectIngredientNames.length;  i++) {
		  var currentOption = document.createElement('option');
		  currentOption.text = selectIngredientNames[i];
		  buildSelector.appendChild(currentOption);
	  }
	}

	createOptions(allIngredients, ingredientDropdown);

	function dropdownBubbleCreated(){
		setBubblePlot(ingredientDropdown.value);
	}

	ingredientDropdown.addEventListener('change', dropdownBubbleCreated, false);
	});
</script>
<?php
include("./header_footer/footer.php");
?>
