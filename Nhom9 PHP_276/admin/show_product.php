<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->
        <link rel="stylesheet" href="../components/header_admin/style.css">
        <link rel="stylesheet" href="./style.css">
	<title></title>
	<style>
		table {
			margin: 24px auto;
			border-collapse: collapse;
			width: 90%;
			box-sizing: border-box;
			color: black;
			font-family: Arial, Helvetica, sans-serif;;
			font-size: 17px;
			text-align: left;
		}
		td{
			width: max-content;
			padding: 8px;
			border: 1px solid #ccc;
		}
		th {
			background-color: #588c7e;
			color: white;
			text-align: center;
			border: 1px solid #ccc;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2
		}

		button {
			margin-top: 10px;
			padding: 8px 12px;
			background-color: #8daf15;
			color: #fff;
			border: none;
		}
		button:hover{
			cursor: pointer;
			opacity: 0.7;
		}
	</style>
</head>
<body>
	<?php

include 'connect_db.php';

if(!empty($_GET['delete_id']))
{

	$id =  $_GET['delete_id'];
	$sql = "DELETE FROM comment WHERE ProductDetailID =$id";
	$result = $conn->query($sql);


	$sql = "DELETE FROM productdetail WHERE ProductID =$id";


$result = $conn->query($sql);


	if ($result) {
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
//echo "<a href='show_product.php'>back</a>";
?>

	<?php 
	include_once("../components/header_admin/index.php");?>
	<div style="display: flex; flex-direction: row; margin-top: 70px; flex: 1;">
		<div class="navigate__admin">
			<a href="show_product.php"><div style="border-right: 5px solid #ffd503;">danh sách sản phẩm</div></a>
			<a href="addproduct.php"><div>thêm sản phẩm</div></a>
			<a href="editproduct.php"><div>cập nhật sản phẩm</div></a>
			<a href="#"><div>xóa sản phẩm</div></a>
			<a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
			<a href="addcompany.php"><div>thêm công ty</div></a>
			<a href="addcapacity.php"><div>thêm dung lượng</div></a>
			<a href="order.php"><div>đơn hàng</div></a>
			<a href="analysis.php"><div>Thống kê doanh thu</div></a>
		</div>
		<div style="display: flex; flex-direction: column; justify-contents: center; align-items: center;">
			<table>
			<tr>
				<th>STT</th>
				<th>Tên sản phẩm</th>
				<th>Giá</th>
				<th style="width: 800px">Mô tả</th>
				<th>Sửa</th>
				<th>Xóa</th>
			</tr>
				<?php
				include 'connect_db.php';


				$sql = "SELECT ProductID,ProductName, Price, ProductNote FROM product";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$Price = "";
                    $dem = 0;
                    for($i = strlen($row["Price"]) - 1; $i >= 0; $i--){
                        if($dem < 2 ){
                            $Price = $Price . $row["Price"][$i];
                            $dem ++;
                        }else if($i > 0){
                            $Price = $Price . $row["Price"][$i].'.';
                            $dem = 0;
                        }else{
                            $Price = $Price . $row["Price"][$i];
                        }
                    }
                    $Price = strrev($Price);
					$id=$row["ProductID"];
					echo "
					<tr>
						<td>" . $row["ProductID"]. "</td>
						<td>" . $row["ProductName"]. "</td>
						<td>" . $Price . "</td>
						<td>" . $row["ProductNote"]. "</td>
						<td>" . "
							<form action='show_option.php' method='POST'>
								<button type='submit' value='$id' name='id'>sửa</button>
							</form>" ."
						</td>
						<td>" . "
						<button type='submit' value='$id'  name='id' onclick='confirmdelete(".$id.")'>xóa</button>
							" ."
						</td>
					</tr>";
				}
				echo "</table>";
				} else { echo "0 tìm thấy kết quả"; }

				$conn->close();
			?>

			</table>
			
		</div>
	</div>

		<script type="text/javascript">
function confirmdelete(id) {
  if (confirm("Xóa ?")) {
window.location.href = "show_product.php?delete_id=" + id;
}

}
	</script>

	
</body>
</html>