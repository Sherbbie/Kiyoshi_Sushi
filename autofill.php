<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
  $q = intval($_GET['q']);

$dbconn = pg_connect("host=138.197.131.53 dbname=kiyoshi user=postgres password=newpassword")
if (!$dbconn) {
    ('<h1>Unable to Connect to Database. Please contact administrator.</h1><br/><a class="btn btn-danger" href="mailto:admin@kiyoshisushi.me?Subject=Database%20Down" >Click to Email Administrator</a>' . pg_last_error());
}

pg_select_db($dbconn,"tbldiscount");
$sql="SELECT * FROM discount WHERE id = '".$q."'";
$result = pg_query($dbconn,$sql);

while($row = pg_fetch_array($result)) {
    $discountProduct['productID'];
    $discountPercent['percentDiscountAmount'];
    $discountPrice['priceDiscountAmount'];
    $discountStart['dateStart'];
    $discountEnd['dateFinish'];
}
pg_close($dbconn);
?>
</body>
</html>
