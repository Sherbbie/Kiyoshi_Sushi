<?php
	$title = "target special";
	$date = "28/10/2016";
	$filename = "register.php";
	$banner = "Register a new account";
	$description = "This page is to serve as a platform for logging into an account for the Kiyoshi Sushi website";
	include("./header_footer/header.php");

	// variables

 	if ($_SERVER["REQUEST_METHOD"] == "GET")
 	{
		//When page loads the first time request method will always be GET
		//can be used to make decisions and initialize variables
		//gets users who have made past orders
 		$sql = "SELECT distinct user_id FROM public.tblorder;";
		$result = pg_query($sql);
		$user_count = pg_num_rows($result);
		$users = array (array());
		// 0 = user_id, 1 = favorite_product_id, 2 = quantity of heigest order, 3 = email, 4 = name of favorite product
		//print_r($user_count);
		// creating an array of users who have made orders in the past
		for ($i=0; $i < $user_count; $i++)
		{
			$users[$i][0] = pg_fetch_result($result, $i, "user_id");
		}
		//print_r($users);

		//iterating through each user and getting their past orders

		//$sql = "SELECT tblorder.order_id, user_id, product_id, quantity FROM public.tblorder join public.tblorderlineitem ON tblorder.order_id = tblorderlineitem.order_id where user_id = " . "test".";";
		//echo $sql;
		//echo $user_count;
		for ($i=0; $i < $user_count; $i++)
		{// for each user
			$sql = "SELECT tblorder.order_id, user_id, product_id, quantity FROM public.tblorder join public.tblorderlineitem ON tblorder.order_id = tblorderlineitem.order_id where user_id ='" . $users[$i][0] ."';";

			$result = pg_query($sql) ;
			//echo "<br/>" .$sql;
			$order_count = pg_num_rows($result);

			//echo " order count " . $order_count . "  ";

			$currentHeigestOrder = 0;
			$currentHeigestOrderIndex = 0;
			for ($j=0; $j < $order_count; $j++)
			{
				$orders = pg_fetch_assoc($result, $j);
				if ($currentHeigestOrder < $orders["quantity"])
				{
					$currentHeigestOrder = $orders["quantity"];
					$currentHeigestOrderIndex = $j;
				}

			}
			$users[$i][1] = pg_fetch_result($result, $currentHeigestOrderIndex, "product_id");
			$users[$i][2] = $currentHeigestOrder;

			// getting the users email
			$sql = "SELECT email FROM public.tblusers where user_id = '" .$users[$i][0]."';";
			//echo $sql;
			$result = pg_query($sql);
			//echo pg_fetch_result($result, 0, "email");
			$users[$i][3] = pg_fetch_result($result, 0, "email");

			// getting the name of the favorite product
			$sql = "SELECT name FROM public.tblproducts where product_id = '".$users[$i][1]."';";
			//echo $sql;
			$result = pg_query($sql);
			//echo pg_fetch_result($result, 0, "email");
			$users[$i][4] = pg_fetch_result($result, 0, "name");
			//echo $users[$i][0] . " heighest quantity is ".$currentHeigestOrder;
		}
		//var_dump($users);
		// create table of users with check boxes

		$_SESSION["usersForSpecial"] = $users;
		//var_dump($_SESSION["usersForSpecial"]);
	}
	else if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$sql = "SELECT distinct user_id FROM public.tblorder;";
		$result = pg_query($sql);
		$user_count = pg_num_rows($result);
		//echo $user_count;
		//var_dump($_SESSION["usersForSpecial"]);
		$users = $_SESSION["usersForSpecial"];
		//var_dump($users);
		//echo "assigning values";
		$checkboxes = $_POST["sendDiscount"];
		//var_dump($checkboxes);
		echo "Emails have been sent and discounts have been created";
		for ($i=0; $i < $user_count; $i++)
		{ // things to do for each user

			if (isset($checkboxes[$i]))
			{// the check box for this user has been checked
				// this is where the code to create the discount and send the email should go
				//echo " ". $users[$i][3].",";
				//echo "send email to " . $users[$i][3];
				$specalData = array("product".$users[$i][1],$users[$i][0],date("Y-m-d"));
				$result = pg_execute($connect, "createSpecail",$specalData);
				//var_dump($specalData);
				//echo $result;
			}
		}
	}

?>
<div class="container">
<table border="1px" class="table table-bordered" align="center">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];  ?>">
	<th>User</th>
	<th>Favorite Item</th>
	<th>Quantity Orderd</th>
	<th>Send Discount</th>
	<?php
	//echo "making table";
	for ($i=0; $i < $user_count; $i++)

	{
		//echo $i;
		echo "<tr>";
		echo "<td>" .$users[$i][0]. "</td>";
		echo "<td>" .$users[$i][4]. "</td>";
		echo "<td>" .$users[$i][2]. "</td>";
		echo "<td><input type='checkbox' name='sendDiscount[".$i."]' value='".$users[$i][0]."'><br></td>";
		echo "</tr>";
	}
	?>
	<tr><td colspan="4"><button type="submit" name="method_selection" class="btn btn-default">Send</button></td></tr>
</form>
</table>
</div>
<?php
	include("./header_footer/footer.php");
?>
