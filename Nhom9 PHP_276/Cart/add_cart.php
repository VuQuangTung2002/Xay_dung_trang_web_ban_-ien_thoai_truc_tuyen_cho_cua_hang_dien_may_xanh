<?php
session_start();
require_once("../connect_db.php");
$id = $_GET['id'];
$sql1 = "select ProductID from productdetail where ProductDetailID = ".$id;
$productid = mysqli_fetch_assoc(mysqli_query($con,$sql1));
if(!isset($_SESSION["userId"]) || !isset($_SESSION["username"])){
		if(!in_array($_GET['id'], $_SESSION['cart'])){
			array_push($_SESSION['cart'], $id);
			array_push($_SESSION['quantity'], 1);
		}
}
else{
	$userID =  $_SESSION["userId"];
	$sql = "select ProductDetailID from cartitem where UserID = ".$userID;
	$arr = array();
	$result = mysqli_query($con,$sql);
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result))
			array_push($arr,$row["ProductDetailID"]);
	}
	if(!in_array($id, $arr))
	{
		$query = "INSERT INTO cartitem(UserID,ProductDetailID,CartQuantity) VALUE('$userID','$id',1)";
		mysqli_query($con, $query);
	}
}
echo '<script language="javascript">window.location="http://localhost/Nhom9%20PHP/detailProduct/index.php?q='.$productid["ProductID"].'"</script>';
?>