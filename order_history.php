<?php
	$title = "Order"; 
	include("./header_footer/header.php"); 

	if($_SERVER["REQUEST_METHOD"] == "GET") {
		if (isset($_GET['complete'])) { 
			date_default_timezone_set('America/Toronto');  
			$order = trim($_GET['complete']);
			pg_execute($connect, "orderCompleteUpdate", array(date("Y-m-d H:i"), $order)); 
			echo " <script>
			window.location = \"order_history.php\";
					</script>";
		} 
		if (isset($_GET['pickup'])) {
			date_default_timezone_set('America/Toronto');  
			$order  = trim($_GET['pickup']);
			pg_execute($connect, "pickedUpdate", array(date("Y-m-d H:i"), $order));  
			echo " <script>
			window.location = \"order_history.php\";
					</script>";
		}
	}
?>
 
<script src="https://code.jquery.com/jquery-1.12.3.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">

<div class="row">
	<div class="col-sm-12"><h1>Order</h1></div>
</div>

<table id="orderID" class="display"  >
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Taxes</th>
                <th>Order Made Datetime</th>
				<th>Order Pickup Datetime</th>
                <th>Order Completed Datetime</th>
                <th>Payment Method</th> 
				<th>View Orders</th>
				<th>Completed</th>
				<th>Picked Up</th>
            </tr>
        </thead>
         
        <tbody>
		<?php
			$result = pg_execute($connect, "orderSubmit", array());
			
			while ($row = pg_fetch_assoc($result)) {
					?>
			<tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['taxes']; ?></td>
                <td><?php echo $row['order_made_datetime']; ?></td>
				<td><?php echo $row['order_time_pickup']; ?></td> 
				<td><?php echo $row['order_completed_datetime']; ?></td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><button data-toggle="modal" data-target="#<?php echo 'orderNumber'.$row['order_id'];?>" class="btn btn-primary btn-sm">View</button></td>
				<td>
					<?php
						if(trim($row['order_completed_datetime']) =='') {
							?>
								<button onclick="<?php echo 'orderCompleted'.$row['order_id'];?>()">Completed</button>
								<script> 
									function <?php echo 'orderCompleted'.$row['order_id'];?>() {
										window.location = "order_history.php?complete=<?php echo $row['order_id']; ?>"; 
										 
									}		
								</script>
						<?php
						} 
					?> 
				</td>
				<td>
					<?php
						if(trim($row['order_time_pickup']) =='') {
							?>
								<button onclick="<?php echo 'pickup'.$row['order_id'];?>()">Picked Up</button>
								<script> 
									function <?php echo 'pickup'.$row['order_id'];?>() {
										var orderNumber = "<?php echo $row['order_id']; ?>";
										window.location = "order_history.php?pickup=<?php echo $row['order_id']; ?>";
									}		
								</script>
						<?php
						} 
					?> 
				</td>
            </tr> 
			   
		  <div class="modal fade" id="<?php echo 'orderNumber'.$row['order_id'];?>" role="dialog">
			<div class="modal-dialog">
 
			  <div class="modal-content">
				<div class="modal-header" style="background-color: #C1CDCD;">
				  <button type="button" class="close " data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Order <?php echo $row['order_id'];?> </h4>
				</div>
				<div class="modal-body">
 				<?php  
 					$orderInfo = pg_execute($connect, "retrieveOrderProducts", array($row['order_id']));
					while ($order = pg_fetch_assoc($orderInfo)) { 
							echo $order['quantity'].' '.$order['name'].'<br>'; 	 
 					} 
			 
				?>
				</div>
				<div class="modal-footer" >
				  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
				</div>
			  </div>
				<?php 
				}
			?>
			</div>
		  </div>
 
        </tbody>
    </table> 
<div style="height: 10px;"></div>
<script>
$(document).ready(function() {
    $('#orderID').DataTable( {
        "order": [[ 8, "desc" ]]
    } );
} );


</script>
  <?php
 include("./header_footer/footer.php");
?>