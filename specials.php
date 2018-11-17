<?php
	$title = "Specials";
	$date = "11/11/2016";
	$filename = "specials.php";
	$banner = "Display User Associated Specials";
	$description = "This page is to serve as a platform to display all of the specials associated to an activated user.";
	include("./header_footer/header.php");
?>
<br/>
<br/>
<div class="row" style="width:700px;display: inline-block;">
  <div class="row">
  	<div class="col-sm-12">
			<h1>Your Specials</h1>
		</div>
  </div>
  <div class="row" style="padding: 0;margin: 0;">
    <div class="col-sm-12">

		</div>
	</div>

	<?php
		if(isset($_SESSION["LoginUserSession"]) == 1)
		{
		  $user = $_SESSION["LoginUserSession"]["user_id"];
			$date = date("Y-m-d");
			echo "<br/>";

		  $result = pg_execute($connect, "FindSpecials", array($user, $date));

			if(pg_num_rows($result) != 0)
			{
				while ($row = pg_fetch_assoc($result))
				{
					$discount = "";
					$percentage = "";
					$dollars = "";

					$product = "";

					$product_price = "";
					$product_name = "";
					$product_description = "";
					$expires = "";

					$expires = $row['end_date'];
					$product_price = $row['price'];
					$product_name = $row['name'];
					$product_description = $row['description'];
					$percentage = $row['percentage'];
					$dollars = $row['dollars'];

					if($product_price != "")
					{
						$product = "Product: ". $product_name ."<br/>Description: ". $product_description .", <br/>Price: $". $product_price .".";
					}
					else
					{
						$product = "An Entire Order";
					}

					if($expires == ""){$expires = "Never"; }
					if($percentage != ""){$discount .= " ".$percentage."%";}
					if($dollars != ""){$discount .= " $".$dollars."";}
					echo "<div class=\"row\" style=\"padding: 0; margin: 0;background-color:#e5e6e8;box-shadow: 1px 2px 3px rgba(0,0,0,.5);padding-top:10px;\"><div class=\"col-sm-12\"><p>
					Discount Code:</p><p class=\"code\"> <strong>".
					$row['discount_id'].
					"</strong></p>".
					"A Discount Of: <strong>".
					$discount.
					"</strong>! <p><br/><strong>Qualifies For:</strong><br/>".
					$product
					."</p>".
					"<p> Expires: ".
					$expires.
					"</div></div>";

					echo "<br/>";
				}
			}
			else
			{
				echo "You have no specials!";
			}












		}
	?>
</div>





<?php
	include("./header_footer/footer.php");
?>
