<?php
	$title = "Order Confirmation";
	$date = "28/10/2016";
	$filename = "order_confirmation.php";
	$banner = "confirm your order";
	$description = "this page is where you confirm your order and select your payment";
	include("./header_footer/header.php");
?>




<?php

	if($_SERVER["REQUEST_METHOD"] == "GET")
	{
		//echo "get";
		$paymentselection = "";
		$price = "";
		$orderNumber = "";
		$headingMessage = "Please Select a payment method";
		//echo "get";
		$orderInfo = $_SESSION["selectedItemsArray"];
		//var_dump($orderInfo);
		echo $_SESSION["visaCheckout"];
		$runningTotal = 0;
	}
	elseif($_SERVER["REQUEST_METHOD"] == "POST")
	{

		//echo "post";
		$orderInfo = $_SESSION["selectedItemsArray"];

		//$_SESSION["price"] = 10;
		$_SESSION["orderNumber"] = 123;
		$headingMessage = "";
		//echo $_POST["method_selection"];
		// handling diffrent payment methods
		if (isset($_POST["method_selection"]))
		{	// logic for when a payment method is selected
			//echo "method selection";

			$paymentselection = $_POST["paymentselection"];
			$price = $_SESSION["price"];
			//echo $price;
		}
		else
		{ 	// logic for processing payment and redirecting to payment success deal with pickup date later
			$price = $_SESSION["price"];
			//echo $price;
			//echo "payment stuff";
			$paymentMethod = "";
			if (isset($_POST["walkIn"]))
			{
				$paymentMethod = "walkin";
			}
			else if (isset($_POST["creditCard"])) {
				$paymentMethod = "credit";
			}
			else
			{
				$paymentMethod = "visaCheckout";

			}
			//echo $paymentMethod;
			//echo "create order";
			$sql = "SELECT order_id FROM public.tblorder order by order_id DESC;";
			$result = pg_query($sql) ;
			$order_id = pg_num_rows($result)+1;
			//echo $order_id;
			$taxes = round($price *0.13,2);
			$orderDataForInsert = array($order_id,$_SESSION["CustomerSession"]["user_id"],$taxes,date("Y-m-d H:i:s"),$paymentMethod);

			var_dump($orderDataForInsert);
			$result = pg_execute($connect, "createOrder",$orderDataForInsert); // creates the entry in tblorder

			// order line items
			for ($i=0; $i < count($orderInfo,0); $i++)
			{
				$result = pg_execute($connect, "createOrderLineItem",array($order_id,$orderInfo[$i][0],$orderInfo[$i][5]));
			}

			echo "the redirect should happen now";

			$_SESSION["orderNumber"] = $order_id;
			//echo $order_id;
			header("Location: payment_success.php");
			die();
		}
	}

?>

<script type="text/javascript">
// this stuff makes the visa work
	//alert("redirect");
	var redirect = function(url, method) {
	    var form = document.createElement('form');
	    form.method = method;
	    form.action = url;
	    form.submit();
	};
	function onVisaCheckoutReady(){
		V.init( {
			apikey: "ESD9VFCZYO4K74RNWJDF13wWKzvk8wlvo4DFm7E71mW5w3EDI",
			paymentRequest:{
			currencyCode: "CAD",
			total: <?php echo $_SESSION["price"];?>
		}
		});
		V.on("payment.success", function(payment)
		{
			//alert(JSON.stringify(payment));
			alert("success");
			//sucess code, following line redirects
			//sessionStorage.setItem('visaCheckout', 1);
			redirect("http://www.kiyoshisushi.me/order_confirmation.php/",'post')
			//window.location.href = "http://www.kiyoshisushi.me/order_confirmation.php/";
		});
		V.on("payment.cancel", function(payment)
		{
			//alert(JSON.stringify(payment));
			//cancle code

		});
		V.on("payment.error", function(payment, error)
		{
			alert(JSON.stringify(error));
			//error code
		});
	}
</script>
<div class="container">
<h1>Your Order</h1>
<table border="1px" class="table table-bordered" align="center">
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Quantity</th>
<th>Total Price</th>

	<?php
	// order summary
	//echo count($orderInfo,0);
	for ($i=0; $i < count($orderInfo,0); $i++)
	{

		echo "<tr>";
		echo "<td> ".$orderInfo[$i][1]." <br> </td>";
		echo "<td> ".$orderInfo[$i][3]." <br> </td>";
		echo "<td> $".$orderInfo[$i][2]." <br> </td>";
		echo "<td> ".$orderInfo[$i][5]." <br> </td>";
		echo "<td>$".$orderInfo[$i][2] * $orderInfo[$i][5]."</td>";
		echo "</tr>";
		$runningTotal = $runningTotal + ($orderInfo[$i][2] * $orderInfo[$i][5]);
	}
	echo "<tr>";
	echo "<td colspan='4'>Order Total:</td>";
	echo "<td> $".$runningTotal." </td>";
	echo "</tr>";
	$_SESSION["price"] = $runningTotal;
	 ?>
</table>
</div>

<h1><?php echo $headingMessage?></h1>
<!--this is the drop down box -->
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
	<select id="maymetselection" name="paymentselection">
	  <option value="visaCheckout" <?php if ($paymentselection == "visaCheckout") echo ' selected="selected"'; ?>>Visa Checkout</option>
	  <option value="creditcard" <?php if ($paymentselection == "creditcard") echo ' selected="selected"'; ?>>Credit Card</option>
	  <option value="walkin" <?php if ($paymentselection == "walkin") echo ' selected="selected"'; ?>>Walk-In</option>
	</select>
	<input size="16" type="text" value="<?php date_default_timezone_set('America/Toronto'); echo date("Y-m-d H:i"); ?>" readonly class="form_datetime">

	<script type="text/javascript">
	    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
	</script>
	<button type="submit" name="method_selection" class="btn btn-default">Select</button>

</form>


<!-- various divs for each payment method -->
<div id="visaCheckout" <?php if (strcmp($paymentselection,"visaCheckout") == 0) {echo "";} else {echo 'style="display:none;"';} ?>>
	<img alt="Visa Checkout" class="v-button" role="button"
	src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png"/>
	<script type="text/javascript"
	src="https://sandbox-assets.secure.checkout.visa.com/checkout-widget/resources/js/integration/v1/sdk.js">
	</script>
</div>

<div id="ManualCreditCard" <?php if (strcmp($paymentselection,"creditcard") == 0) {echo "";} else {echo 'style="display:none;"';} ?>>
	<div class="container">
	<!-- credit card payment section section-->
  <form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
    <fieldset>
      <legend>Payment</legend>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-holder-name">Name on Card</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card-holder-name" id="card-holder-name" placeholder="Card Holder's Name">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="card-number">Card Number</label>
        <div class="col-sm-9">
          <input type="text" class="form-control" name="card-number" id="card-number" placeholder="Debit/Credit Card Number">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="expiry-month">Expiration Date</label>
        <div class="col-sm-9">
          <div class="row">
            <div class="col-xs-3">
              <select class="form-control col-sm-2" name="expiry-month" id="expiry-month">
                <option>Month</option>
                <option value="01">Jan (01)</option>
                <option value="02">Feb (02)</option>
                <option value="03">Mar (03)</option>
                <option value="04">Apr (04)</option>
                <option value="05">May (05)</option>
                <option value="06">June (06)</option>
                <option value="07">July (07)</option>
                <option value="08">Aug (08)</option>
                <option value="09">Sep (09)</option>
                <option value="10">Oct (10)</option>
                <option value="11">Nov (11)</option>
                <option value="12">Dec (12)</option>
              </select>
            </div>
            <div class="col-xs-3">
              <select class="form-control" name="expiry-year">
                <option value="13">2013</option>
                <option value="14">2014</option>
                <option value="15">2015</option>
                <option value="16">2016</option>
                <option value="17">2017</option>
                <option value="18">2018</option>
                <option value="19">2019</option>
                <option value="20">2020</option>
                <option value="21">2021</option>
                <option value="22">2022</option>
                <option value="23">2023</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label" for="cvv">Card CVV</label>
        <div class="col-sm-3">
          <input type="text" class="form-control" name="cvv" id="cvv" placeholder="Security Code">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
          <button type="submit" name="creditCard" class="btn btn-success">Pay Now</button>
        </div>
      </div>
    </fieldset>
  </form>
</div>

</div>

<div id="walkIn" <?php if (strcmp($paymentselection,"walkin") == 0) {echo "";} else {echo 'style="display:none;"';} ?>>
	<form class="form-horizontal" role="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<button type="submit" name="walkIn" class="btn btn-success">Place Order</button>
	</form>
</div>

<?php
	include("./header_footer/footer.php");
?>
