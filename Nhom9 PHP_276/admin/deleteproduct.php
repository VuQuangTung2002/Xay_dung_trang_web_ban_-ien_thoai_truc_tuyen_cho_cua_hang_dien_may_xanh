

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		a {
    display: block;
    width: 115px;
    height: 25px;
    background: #4E9CAF;
    padding: 10px;
    text-align: center;
    border-radius: 5px;
    color: white;
    font-weight: bold;
    line-height: 25px;
    text-decoration: none;
}
	</style>
</head>
<body>
<?php

include 'connect_db.php';

if(!empty($_GET['id']))
{

	$id =  $_GET['id'];
	$sql = "DELETE FROM comment WHERE ProductID =$id";
	$result = $conn->query($sql);


	$sql = "DELETE FROM productdetail WHERE ProductID =$id";

	if ($conn->query($sql)) {
			$message = " Xóa thành công";
    echo "<script>alert('$message');</script>";

} else {
	$message = " Sản phẩm này đang trong quá trình xử lý";
    echo "<script>alert('$message');</script>";
}


	$sql = "DELETE FROM productimage WHERE ProductID =$id";
	$result = $conn->query($sql);

	$sql = "DELETE FROM product WHERE ProductID =$id";
	$result = $conn->query($sql);


}
echo "<a href='show_product.php'>back</a>";
?>
</body>
</html>