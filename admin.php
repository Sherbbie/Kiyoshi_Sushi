<?php
	$title = "Admin Dashboard";
	$date = "11/2/2016";
	$filename = "admin.php";
	$banner = "Admin Dashboard";
	include("./header_footer/header.php");
?>
<div class="row">
	<div class="col-sm-12"><h1>Admin Dashboard</h1></div>
</div>
<div class="row">
  <div class="col-sm-6"><h1>Employee</h1>
    <a class="btn btn-default" style="background-color:grey; color:white; width:25%;" href="./add_employee.php">Add Employee</a>
    <a class="btn btn-default" style="background-color:grey; color:white; width:25%;" href="./edit_employee.php">Edit Employee</a>
  </div>
	<div class="col-sm-6"><h1>Product Ingredients</h1>
    <a class="btn btn-default" style="background-color:purple; color:white; width:25%;" href="./add_product_ingredient.php">Add Product Ingredient</a>
    <a class="btn btn-default" style="background-color:purple; color:white; width:25%;" href="./edit_product_ingredient.php">Edit Product Ingredient</a>
  </div>
  <div class="col-sm-6"><h1>Products</h1>
    <a class="btn btn-default" style="background-color:blue; color:white; width:25%;" href="./add_product.php">Add Product</a>
    <a class="btn btn-default" style="background-color:blue; color:white; width:25%;" href="./edit_product.php">Edit Product</a>
  </div>
  <div class="col-sm-6"><h1>Suppliers</h1>
    <a class="btn btn-default" style="background-color:orange; color:white; width:25%;" href="./add_supplier.php">Add Supplier</a>
    <a class="btn btn-default" style="background-color:orange; color:white; width:25%;" href="./edit_supplier.php">Edit Supplier</a>
  </div>
  <div class="col-sm-6"><h1>Ingredients</h1>
    <a class="btn btn-default" style="background-color:green; color:white; width:25%;" href="./add_ingredient.php">Add Ingredient</a>
    <a class="btn btn-default" style="background-color:green; color:white; width:25%;" href="./edit_ingredient.php">Edit Ingredient</a>
  </div>
	<div class="col-sm-6"><h1>Discounts</h1>
    <a class="btn btn-default" style="background-color:red; color:white; width:25%;" href="./add_discount.php">Add Discount</a>
    <a class="btn btn-default" style="background-color:red; color:white; width:25%;" href="./edit_discount.php">Edit Discount</a>
  </div>
	<div class="col-sm-6"><h1>Customers</h1>
		<a class="btn btn-default" style="background-color:black; color:white; width:25%;" href="./disable_user.php">Disabled Users</a>
		<a class="btn btn-default" style="background-color:black; color:white; width:25%;" href="./target_special.php">Top Ordered Customer</a>
	</div>
	<div class="col-sm-6"><h1>Order</h1>
  	<a class="btn btn-default" style="background-color:brown; color:white; width:25%;" href="./order_history.php">Order History</a>
  </div>
</div>

<?php
  include("./header_footer/footer.php");
?>
