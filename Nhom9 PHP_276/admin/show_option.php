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
	
	$id = $_GET['delete_id'];

	$sql = "DELETE FROM productdetail WHERE ProductDetailID =$id";

	if ($conn->query($sql)) {
    $message = " Xóa thành công";
    echo "<script>alert('$message');</script>";



} else {
	$message = " Sản phẩm này đang trong quá trình xử lý";
    echo "<script>alert('$message');</script>";
}


}

//echo "<a href='show_option.php'>back</a>";
	?>


	<?php include_once("../components/header_admin/index.php");?>
	<div style="display: flex; flex-direction: row; margin-top: 70px; flex: 1;">
		<div class="navigate__admin">
			<a href="show_product.php"><div>danh sách sản phẩm</div></a>
			<a href="addproduct.php"><div>thêm sản phẩm</div></a>
			<a href="editproduct.php"><div>cập nhật sản phẩm</div></a>
			<a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
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
				<th>Color</th>
				<th>Capacity</th>
				<th>Quantity</th>
				<th >Screen</th>
				<th>OS</th>
				<th>Camera</th>
				<th>Chip</th>
				<th>Pin</th>
				<th>Company</th>
				<th>Sửa</th>
				<th>Xóa</th>


			</tr>
				<?php
				include 'connect_db.php';
				session_start();
                    

				if(!empty($_POST['id']))
				{
					$_SESSION["productid"] = $_POST['id'];
					
				}
				$productid=$_SESSION["productid"];

				$sql = "select * from  product WHERE ProductID =$productid";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo "<h2>Các option của :  ".$data["ProductName"] ."</h2>";
                            }
                        }

				$sql = "SELECT * FROM productdetail WHERE ProductID = $productid";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
					$productdetailid=$row["ProductDetailID"];
					echo "
					<tr>
						<td>" . $row["ProductDetailID"]. "</td>
						<td>" . $row["ColorID"]. "</td>
						<td>" . $row["CapacityID"] . "</td>
						<td>" . $row["Quantity"] . "</td>
						<td>" . $row["ProductScreen"] . "</td>
						<td>" . $row["ProductOS"]. "</td>
						<td>" . $row["ProductCam"] . "</td>
						<td>" . $row["ProductChip"] . "</td>
						<td>" . $row["ProductPin"] . "</td>
						<td>" . $row["CompanyID"] . "</td>
						<td>" . "
							<form action='editoption.php' method='POST'>
								<button type='submit' value='$productdetailid' name='id'>sửa</button>
							</form>" ."
						</td>
						<td>" . "
						<button type='submit' value='$productdetailid' id='pdid' name='id' onclick='confirmdelete(".$productdetailid.")'>xóa</button>
							" ."
						</td>
					</tr>";
				}
				echo "</table>";
				} else { echo "0 tìm thấy kết quả"; }


				echo "<form action='addoption.php' method='POST'>
								<button type='submit' value='$productid' name='add_id'>Thêm option</button>
							</form>";

				$conn->close();
			?>
			
			</table>
			
			<?php
				if(isset($_POST['them'])) { 
					header('Location: addproduct.php');
				} 
				if(isset($_POST['sua'])) { 
					header('Location: editproduct.php');
				} 
			?>
		</div>
	</div>

	<script type="text/javascript">
function confirmdelete(id) {
  if (confirm("Xóa ?")) {
window.location.href = "show_option.php?delete_id=" + id;
}

}
	</script>






</body>
</html>