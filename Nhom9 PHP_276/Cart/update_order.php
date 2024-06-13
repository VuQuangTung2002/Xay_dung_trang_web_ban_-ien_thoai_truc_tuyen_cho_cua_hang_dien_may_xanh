<?php
	require_once("../connect_db.php");
	$id = $_GET['orderid'];
	$sql = "UPDATE orderdetails SET Status = 2 Where OrderID = ".$id;
	mysqli_query($con,$sql);
	echo '<script language="javascript">window.location="http://localhost/Nhom9%20PHP/Cart/index_order.php"</script>';
?>