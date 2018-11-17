<?php
	$title = "Home";
	include("./header_footer/header.php");
?>
<div class="row" style=<?php $css = "\"display: inline-block;margin-left: 0px;margin-right:0px;padding:0px;margin:0px;"; if(isset($_SESSION['LoginUserSession'])) {$css .= "width: 100%;\"";}else{ $css .= "width: 800px;\"";} echo $css;?>>
  <div class="row" style="padding: 0;margin 0;">
  	<div class="col-sm-12">
			<h1>Menu</h1>
		</div>
  </div>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$_SESSION["selectedItemsArray"] = json_decode($_POST["selectedItemsArray"], true);
		//var_dump($_SESSION["selectedItemsArray"]);
		header('Location: order_confirmation.php');
	}

	if(isset($_SESSION['LoginUserSession']))
	{
	echo "<div class=\"row\" style=\"padding: 0;margin 0;\">";
	echo	"<div class=\"col-sm-4\">";
	echo	"</div>";
	echo	"<div class=\"col-sm-4\" style=\"padding: 0;margin 0;\">";
	}
	else
	{
		echo "<div class=\"row\" style=\"padding: 0;margin 0;\">";
		echo "<div class=\"col-sm-12\">";
	}
	?>
  
<?php

$result = pg_execute($connect, "getMenu", array());

if(pg_num_rows($result) != 0)
{
	$type = "";
	$menuItems = "";
	$rowCount = 0;
	while ($row = pg_fetch_assoc($result))
	{
			$menuItems[$rowCount] = array($row['product_id'], $row['name'], number_format($row['price'], 2), $row['description'], $row['type']);
			$rowCount++;
	}

	for($i = 0; $i <= $rowCount-1; $i++)
	{
		$price = "$";
		$price .= $menuItems[$i][2];
		if(isset($_SESSION['LoginUserSession']))
		{
			if($type != $menuItems[$i][4]){$type = $menuItems[$i][4];echo "<div class=\"row\" style=\"padding: 0; margin: 0;text-align:left;\"><div style=\"padding-left: 2px;padding-right:0px;\"class=\"col-sm-12\"><strong>".$type."</strong></div></div><br/>";}
			echo "<div class=\"row\" style=\"padding: 0; margin: 0;background-color:#e5e6e8;box-shadow: 1px 2px 3px rgba(0,0,0,.5);padding-top:10px;\"><div class=\"col-sm-8\" style=\"padding-left:30px;\">
			<p><strong>Product Name: </strong>".
			$menuItems[$i][1].
			"</p>".
			"<p><strong>Description: </strong>".
			$menuItems[$i][3].
			"</p>".
			"<p><strong>Price: </strong>".
			$price.
			"</p>".
			"</div><div class=\"col-sm-4\">";

		}
		else
		{
			echo "<div class=\"row\" style=\"padding: 0; margin: 0;text-align:left;\"><div style=\"padding-left: 2px;padding-right:0px;\"class=\"col-sm-12\"><strong>".$type."</strong></div></div><br/>";
			echo "<div class=\"row\" style=\"padding: 0; margin: 0;background-color:#e5e6e8;box-shadow: 1px 2px 3px rgba(0,0,0,.5);padding-top:10px;\"><div class=\"col-sm-3\"></div><div class=\"col-sm-6\">
			<p><strong>Product Name: </strong>".
			$menuItems[$i][1].
			"</p>".
			"<p><strong>Description: </strong>".
			$menuItems[$i][3].
			"</p>".
			"<p><strong>Price: </strong>".
			$price.
			"</p>".
			"</div><div class=\"col-sm-3\">";
		}
		if(isset($_SESSION["LoginUserSession"]))
		{

			echo "<div class=\"form-group\"><label style=\"padding:0;margin:0;\" class=\"control-label col-sm-6\" style=\"width:47%;float:left;\">Amount:</label>";
			echo "<input type=\"amount\" id=\"ItemInput-".$i."\" value=\"0\" class=\"form-control\" style=\"height:20px;width:25px;padding:0;margin:0;padding-left:2px;margin-right:30px;\"name=\"".$i."\"><br/>";
			echo "<input type=\"submit\" class=\"AddItem form-control\" style=\"height:25px;width:80%;padding:0;margin:0;\" value=\"Add to Order\" name=\"".$i."\">";
			echo "</div></div></div>";

		}
		else
		{
			echo "</div></div>";
		}


		echo "<br/>";
	}

}

 ?>

	<?php if(isset($_SESSION['LoginUserSession']))
	{

		echo "</div><div class=\"col-sm-4\" style=\"padding: 0;margin 0;\">";
		echo "<div class=\"row\" id=\"orderItems\" style=\"height:500px;padding: 0; margin: 0;background-color:#e5e6e8;box-shadow: 1px 2px 3px rgba(0,0,0,.5);padding-top:10px;width:70%;display: inline-block;\">";
		echo "<div class=\"row\" style=\"padding:0px;margin:0px;padding-left:5px;\"><div class=\"col-sm-3\"></div><div class=\"col-sm-6\" style=\"padding: 0; margin: 0;text-align:center;\"><strong>Selected Items</strong></div><div id=\"checkout-sm\" class=\"col-sm-3\" style=\"margin:0;padding:0px;right:5px;\"></div></div";
		echo "<hr/>";
		echo "<br/>";
		echo "<br/>";
	}
	else {

	}

	echo "</div></div></div>";
	?>
	<script>
			$(document).ready(function() {
				var subValid = false;
				var selectedItems = [];
				var itemPlaceholder = [];
		    $(".AddItem").click(function(){
					var itemRemoval = "";
					var menuItems = <?php echo json_encode($menuItems ); ?>;
					var index = this.name;
					var name = menuItems[index][1];

					var amount = document.getElementById("ItemInput-" + index).value;
					if(amount != 0)
					{
						$("<div id=\"oc-" + index + "\" class=\"row\" style=\"padding: 0; margin: 0;background-color:white;box-shadow: 0px 0px 3px rgba(0,0,0,.5);padding-top:10px;padding-bottom:10px;width:80%;display:inline-block;\"><div class=\"col-sm-2\"></div><div class=\"col-sm-8\">Name: " + name + " Amount: " + amount + "</div>"
						+ "<div class=\"col-sm-2\"><input type=\"submit\" name=\"noc-" + index + "\" class=\"RemoveItem form-control\" style=\"height:25px;width:25px;padding:0;margin:0;\" value=\"X\"></div></div>").appendTo("div#orderItems");
						// *Don't hurt me...
						itemPlaceholder.push(menuItems[index][0]);
						itemPlaceholder.push(menuItems[index][1]);
						itemPlaceholder.push(menuItems[index][2]);
						itemPlaceholder.push(menuItems[index][3]);
						itemPlaceholder.push(menuItems[index][4]);
						itemPlaceholder.push(amount);
						selectedItems.push(itemPlaceholder);
						itemPlaceholder = [];
						if(subValid == false)
						{
							$("	<form method=\"post\"><div class=\"form group\"><input type=\"hidden\" name=\"selectedItemsArray\" id=\"selectedItemsArray\"><input id=\"Checkout\" type=\"submit\" class=\"Checkout form-control\" style=\"height:25px;width:80%px;padding:0;margin:0;\" value=\"Checkout\"><div></form>").appendTo("div#checkout-sm");
							subValid = true;
							$(".Checkout").click(function(){
									hiddenInputItems = document.getElementById("selectedItemsArray");
									hiddenInputItems.value = JSON.stringify(selectedItems);
							});
						}

						$('.RemoveItem').click(function(){
							var thisIndex = 0;
							var thisName = this.name;
							console.log(thisName);
							var rowElement = this.parentNode.parentNode;
							thisIndex = thisName.replace('noc-', '');
							rowElement.parentNode.removeChild(rowElement);
							//element.parentNode.removeChild(element);
							console.log(thisIndex);
							selectedItems.splice(thisIndex, 1);
						});
					}
		    })
			});

	</script>
<?php
	echo "</div></div>";
	include("./header_footer/footer.php");
?>
