<?php
	$title = "Payment Success"; 
	include("./header_footer/header.php");
?>

<?php 
	echo "<h4>Your order has been placed. <br/> Your order number is " . $_SESSION["orderNumber"] . "</h4>";
?>

<?php
	include("./header_footer/footer.php");
?>