<?php
	session_start();
	require_once("../connect_db.php");
	if(isset($_SESSION["userId"]) || isset($_SESSION["username"])){
		$query = "DELETE FROM cartitem Where CartID = ".$_GET['cartID'];
		mysqli_query($con,$query);
	}
	else{
	$cartid = array_search($_GET['cartID'], $_SESSION['cart']);
	unset($_SESSION['cart'][$cartid]);
	$_SESSION['cart'] = array_values($_SESSION['cart']);
	}
	echo '<script language="javascript">window.location="http://localhost/Nhom9%20PHP/Cart/index.php"</script>';
?>