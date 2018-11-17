<html>
<head>
<script type="text/javascript">
	function onVisaCheckoutReady(){
		V.init( {
			apikey: "ESD9VFCZYO4K74RNWJDF13wWKzvk8wlvo4DFm7E71mW5w3EDI",
			paymentRequest:{
			currencyCode: "USD",
			total: "10.00"
		}
		});
		V.on("payment.success", function(payment)
		{
			alert(JSON.stringify(payment)); 
			alert("success");
			//sucess code
			window.location.href = "http://www.example.com";
		});
		V.on("payment.cancel", function(payment)
		{
			alert(JSON.stringify(payment)); 
			//cancle code
		});
		V.on("payment.error", function(payment, error)
		{
			alert(JSON.stringify(error));
			//error code
		});
	}

</script>
</head>


<body>
<img alt="Visa Checkout" class="v-button" role="button"
src="https://sandbox.secure.checkout.visa.com/wallet-services-web/xo/button.png"/>
<script type="text/javascript"
src="https://sandbox-assets.secure.checkout.visa.com/
checkout-widget/resources/js/integration/v1/sdk.js">
</script>


</body>
</html>