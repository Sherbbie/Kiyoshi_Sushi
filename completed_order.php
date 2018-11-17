<?php
	$title = "Completed Order"; 
	include("./header_footer/header.php");
 
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (isset($_POST['completedOrder'])) {
	
		$completeTime = trim($_POST["date"]).' '.trim($_POST["time"]);	
		$order = trim($_POST["order"]) ;	
		
 		$sql = "UPDATE public.tblorder SET order_completed_datetime='".$completeTime."' WHERE order_id='".$order."';";
	 
		if (pg_affected_rows( pg_query($sql) )) {
			echo '<script language="javascript">';
			echo 'window.addEventListener("load", function(){ alert("Order '.$order.' Has Successfully Been Updated.")});';
			echo '</script>';
		} else {
				echo '<script language="javascript">';
				echo 'window.addEventListener("load", function(){ alert("Order '.$order.' Has Not Been Successfully Updated.")});';
				echo '</script>';
			}
	}

}	
	
?>

<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">


		<div class="row">
			<div class="col-sm-12"><h1>Completed Order</h1></div>
		</div>

		<form class="form-horizontal" action='' method='post'>
	
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="order_id">Order ID:</label>
			<div class="col-sm-3">
			  <select required class="form-control" name="order"  id="order_id">
 				<option value=""></option>
				<?php
					$result = pg_query($connect, "SELECT*FROM tblorder");

					while ($row = pg_fetch_assoc($result)) {
						echo '<option value="' . $row['order_id'] . '">' . $row['order_id'] . '</option>';
					}
					?>
			</select>
			</div>
		</div>
	  
		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="date">Date:</label>
			<div class="col-sm-3">
			  <div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				<input  id="date" name="date" type="text" required class="form-control" pattern="\d{1,2}-\d{1,2}-\d{4}" oninvalid="this.setCustomValidity('Please Input Date in mm-dd-YYYY Format')" oninput="setCustomValidity('')" /> 
			</div> 
			</div>
		</div>
	
	<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" for="time">Time:</label>
			<div class="col-sm-3">
			  <div class="input-group">
				<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span> 
				<input required  id="time" name="time" type="time" pattern="^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9]\s*[aApP][mM]\s*$" required class="form-control" oninvalid="this.setCustomValidity('Please Input Time in HH:mm:ss AM/PM Format')" oninput="setCustomValidity('')" />
			</div> 
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-sm-6" style="width:47%;" > </label>
			<div class="col-sm-3" style="">
				<button type="submit" class="btn btn-default" name="completedOrder" style="width:100%;">Submit</button>
			</div>
		</div>
		 
	</form>
</div>

<script>  
		var dateTimeRetrieve = 	new Date()
		var currentTime = dateTimeRetrieve.toLocaleTimeString();

		var currentMonth = dateTimeRetrieve.getMonth() + 1
		var currentDay = dateTimeRetrieve.getDate()
		var currentYear = dateTimeRetrieve.getFullYear()
		var currentDates = (currentMonth + "-" + currentDay + "-" + currentYear)

		document.getElementById('date').value =currentDates;
		 document.getElementById('time').value =currentTime; 
</script>

<?php
    include("./header_footer/footer.php");
 ?>