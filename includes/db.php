<?php

function connect_database(){
	$dbconn = pg_connect("host=138.197.131.53 dbname=kiyoshi user=postgres password=newpassword")
    or die('<h1>Unable to Connect to Database. Please contact administrator.</h1><br/><a class="btn btn-danger" href="mailto:admin@kiyoshisushi.me?Subject=Database%20Down" >Click to Email Administrator</a>' . pg_last_error());

	return $dbconn;
}

function emptyDateTimePicker() {
	 ?>
	<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

	<script type="text/javascript">
	$(function() {

	  $('input[name="discountDuration"]').daterangepicker({
		  autoUpdateInput: false,
		  locale: {
			  cancelLabel: 'Clear'
		  }
	  });

	  $('input[name="discountDuration"]').on('apply.daterangepicker', function(ev, picker) {
		  $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	  });

	  $('input[name="discountDuration"]').on('cancel.daterangepicker', function(ev, picker) {
		  $(this).val('');
	  });

	});
	</script>
<?php
}
$connect =  connect_database();
$findUser = pg_prepare($connect, "FindUser", "SELECT * FROM tblusers WHERE user_id=$1");
$registerUser = pg_prepare($connect, "RegisterUser", "INSERT INTO tblUsers(user_id, street_address, password, last_name, first_name, email, city, postal_code, province, disable_user, phone_number) values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11)");
$registerEmployee = pg_prepare($connect, "RegisterEmployee", 'INSERT INTO public.tblemployee(user_id, "position", sin_number, annual_salary, start_date, end_date, admin_privileges) VALUES ($1, $2, $3, $4,$5, $6, $7);');
$loginUser = pg_prepare($connect, "LoginUser", "SELECT user_id, password FROM tblUsers WHERE user_id=$1 AND password=$2");
$loginGetUser = pg_prepare($connect, "LoginGetUser", "SELECT * FROM tblUsers WHERE user_id=$1");
$findCustomer = pg_prepare($connect, "FindCustomer", "SELECT * FROM tblCustomers WHERE user_id=$1");
$findEmployee = pg_prepare($connect, "FindEmployee", "SELECT * FROM tblEmployee WHERE user_id=$1");
$registerCustomer = pg_prepare($connect, "RegisterCustomer", "INSERT INTO tblCustomers VALUES ($1, $2, $3, $4, $5, $6, $7)");
$newMarketPrice = pg_prepare($connect, "NewMarket", "INSERT INTO tblingredientprice(ingredient_id, date_time_added, supplier_id, market_price) VALUES ($1, $2, $3, $4);");
$deleteMarket = pg_prepare($connect, "removeMarket", "DELETE FROM tblingredientprice WHERE ingredient_id=$1 AND date_time_added=$2 AND supplier_id=$3;");

$findMarketSupplier = pg_prepare($connect, "selectMarketSupp", "SELECT * FROM tblingredientprice WHERE ingredient_id=$1 AND date_time_added=$2 AND supplier_id=$3;");

$findProduct = pg_prepare($connect, "selectProduct", "SELECT * FROM tblproducts WHERE name=$1;");
$allProduct = pg_prepare($connect, "selectAllProduct", "SELECT * FROM tblproducts;");
$insertProduct = pg_prepare($connect, "insertProduct", "INSERT INTO public.tblproducts(product_id, name, price, description, on_menu, type) VALUES ($1, $2, $3, $4, $5, $6);");

$updateUser = pg_prepare($connect, "updateUser", "UPDATE tblUsers SET disable_user=$2 WHERE user_id=$1");
$searchUser = pg_prepare($connect, "searchUser", "SELECT * FROM tblUsers WHERE user_id=$1");

$updateCustomer = pg_prepare($connect, "UpdateCustomer", "UPDATE tblUsers SET street_address=$2, email=$3, city=$4, postal_code=$5, province=$6, phone_number=$7, first_name=$8, last_name=$9 WHERE user_id=$1");

$updateEmployee = pg_prepare($connect, "UpdateEmployee", 'UPDATE public.tblemployee SET "position"=$2, sin_number=$3, annual_salary=$4, start_date=$5, end_date=$6, admin_privileges=$7 WHERE user_id=$1;');
$searchEmployee = pg_prepare($connect, "searchEmployee", "SELECT * FROM tblEmployee WHERE user_id=$1");

$discountGetOne = pg_prepare($connect, "discountCodeLook", "SELECT * FROM tbldiscount WHERE discount_id=$1");
$discountGetSearch = pg_prepare($connect, "discountSearch", "SELECT * FROM tbldiscount WHERE discount_id=$1");

$discountInsert = pg_prepare($connect, "discountCodeInsert", "INSERT INTO tbldiscount(discount_id, product_id, percentage, dollars, start_date, end_date) VALUES ($1, $2, $3, $4, $5, $6);");
$discountUpdate = pg_prepare($connect, "DiscountUpdate", "UPDATE tbldiscount SET product_id=$2, percentage=$3, dollars=$4, start_date=$5, end_date=$6 WHERE discount_id=$1");

$selectSupplier = pg_prepare($connect, "supplierFind", "SELECT * FROM tblsupplier WHERE first_name=$1 AND last_name=$2 AND email=$3;");
$selectSupplier = pg_prepare($connect, "supplierFindAll", "SELECT * FROM tblsupplier;");
$insertSupplier = pg_prepare($connect, "supplierInsert", "INSERT INTO tblsupplier(supplier_id, first_name, last_name, email, phone_number) VALUES ($1, $2, $3, $4, $5);");
$updateSupplier = pg_prepare($connect, "supplierUpdate", "UPDATE tblsupplier SET first_name=$2, last_name=$3, email=$4, phone_number=$5 WHERE supplier_id=$1");
$supplierLook = pg_prepare($connect, "supplierIDLook", "SELECT * FROM tblsupplier WHERE supplier_id=$1");
$supplierSearch = pg_prepare($connect, "supplierSearch", "SELECT * FROM tblsupplier WHERE supplier_id=$1");

$insertIngredient = pg_prepare($connect, "ingredientInsert", "INSERT INTO public.tblingredient(ingredient_id, ingredient_name) VALUES ($1, $2);");
$selectIngredient = pg_prepare($connect, "ingredientFind", "SELECT * FROM tblingredient WHERE ingredient_name=$1;");
$selectIngredientAll = pg_prepare($connect, "ingredientFindAll", "SELECT * FROM tblingredient;");
$updateIngredient = pg_prepare($connect, "ingredientUpdate", "UPDATE tblingredient SET ingredient_name=$2 WHERE ingredient_name=$1");
$ingredientLook = pg_prepare($connect, "ingredientIDLook", "SELECT * FROM tblingredient WHERE ingredient_name=$1");
$ingredientSearch = pg_prepare($connect, "ingredientSearch", "SELECT * FROM tblingredient WHERE ingredient_name=$1");

$updateProduct = pg_prepare($connect, "productUpdate", "UPDATE tblproducts SET price=$2, description=$3, on_menu=$4, type=$5 WHERE name=$1");
$productLook = pg_prepare($connect, "productIDLook", "SELECT * FROM tblproducts WHERE name=$1");
$productSearch = pg_prepare($connect, "productSearch", "SELECT * FROM tblproducts WHERE name=$1");

$findSpecials = pg_prepare($connect, "FindSpecials", "SELECT s.user_id, d.end_date, s.discount_id, d.percentage, d.dollars, p.name, p.price, p.description FROM tblSpecials as s INNER JOIN tblDiscount as d ON s.discount_id=d.discount_id LEFT JOIN tblProducts as p ON d.product_id=p.product_id WHERE s.user_id=$1 AND (d.end_date>=$2 OR d.end_Date is NULL)");
$getMenu = pg_prepare($connect, "getMenu", "SELECT * FROM tblproducts WHERE on_menu='1' ORDER BY type ASC");

$createOrder = pg_prepare($connect, "createOrder","INSERT INTO public.tblorder( order_id, user_id, taxes, order_made_datetime, payment_method) VALUES ($1, $2, $3, $4, $5);");
$createOrderLineItem = pg_prepare($connect, "createOrderLineItem", "INSERT INTO public.tblorderlineitem(order_id, product_id, quantity) VALUES ($1, $2, $3);");
$createSpecial = pg_prepare($connect,"createSpecail", "INSERT INTO public.tblspecials(discount_id, user_id, datetime_assigned) VALUES ($1, $2, $3);");
//$getUsersWhoOrder = pg_prepare($connect, "getUsersWhoOrder", "SELECT distinct user_id FROM public.tblorder;");
//$getOrderInfoForUser = pg_prepare($connect, "getOrderInfoForUser", "SELECT tblorder.order_id, user_id, product_id, quantity FROM public.tblorder join public.tblorderlineitem ON tblorder.order_id = tblorderlineitem.order_id where user_id = $1;");

$getOrderHistory = pg_prepare($connect, "retrieveOrderProducts", "SELECT name, quantity FROM public.tblorderlineitem natural JOIN tblproducts where order_id=$1;");

$getOrderHistory = pg_prepare($connect, "getOrderHistory", "SELECT * FROM tblorder WHERE order_made_datetime='1' ORDER BY type ASC");
$submitOrderHistory = pg_prepare($connect, "orderSubmit", "SELECT * FROM tblorder");

$forgotUsers = pg_prepare($connect, "forgotUser", "SELECT * FROM tblusers where user_id=$1 and email=$2;");

$selectProductIngredient  = pg_prepare($connect, "selectProductIngredient", "SELECT * FROM tblitemingredient WHERE ingredient_id=$1 AND product_id=$2");
$insertProductIngredient = 	 pg_prepare($connect,"createProductIngredient", "INSERT INTO public.tblitemingredient(
	ingredient_id, product_id, amount, unit_measurement) VALUES ($1, $2, $3, $4);");
$updateProductIngredient = pg_prepare($connect, "productIngredientUpdate", "UPDATE tblitemingredient SET ingredient_id=$2, amount=$3, unit_measurement=$4 WHERE product_id=$1");
$productIngredientLook = pg_prepare($connect, "productIngredientIDLook", "SELECT * FROM tblitemingredient WHERE product_id=$1 AND ingredient_id=$2");
$productIngredientSearch = pg_prepare($connect, "productIngredientSearch", "SELECT * FROM tblitemingredient WHERE product_id=$1 AND ingredient_id=$2");

$orderUpdate = pg_prepare($connect, "orderUpdate", "UPDATE tblorder order_completed_datetime=$1 WHERE order_id=$2;");

$completedUpdate = pg_prepare($connect, "orderCompleteUpdate", "UPDATE tblorder SET order_completed_datetime=$1 WHERE order_id=$2;");
$pickedUpdate = pg_prepare($connect, "pickedUpdate", "UPDATE tblorder SET order_time_pickup=$1 WHERE order_id=$2;");

$discountUpdate = pg_prepare($connect, "UserPasswordChange", "UPDATE tblusers SET password=$2 WHERE user_id=$1");

?>
