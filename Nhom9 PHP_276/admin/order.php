<?php
    include 'connect_db.php';
    if(isset($_POST['id'])){
        $sql = "UPDATE orderdetails SET Status = 1 Where OrderID = ".$_POST['id'];
        $result = mysqli_query($conn,$sql);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->
        <link rel="stylesheet" href="../components/header_admin/style.css">
        <link rel="stylesheet" href="./style.css">
        <title>Order</title>
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
			margin-top: 4px;
            width: 100px;
            padding: 10px 4px;
			background-color: #8daf15;
			color: #fff;
			border: none;
		}
		button:hover{
			cursor: pointer;
			opacity: 0.7;
		}
        select, option{
            width: 160px;
            height: 30px;
            border: 1px solid #000;
            outline: none;
        }
        label{
            display: inline-block;
            width: 40px;
        }
        </style>
    </head>
    <body>
        <?php include_once("../components/header_admin/index.php");?>
        <div style="display: flex; flex-direction: row; margin-top: 70px;">
            <div class="navigate__admin">
                <a href="show_product.php"><div>danh sách sản phẩm</div></a>
                <a href="addproduct.php"><div>thêm sản phẩm</div></a>
                <a href="editproduct.php"><div>cập nhật sản phẩm</div></a>
                <a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
                <a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
                <a href="addcompany.php"><div>thêm công ty</div></a>
                <a href="addcapacity.php"><div>thêm dung lượng</div></a>
                <a href="order.php"><div style="border-right: 5px solid #ffd503;">đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center;">
			<div style="padding: 16px">
            <form method="post" action="">
                <label>Lọc:</label>
                <select name="status" onchange="this.form.submit()">
                    <?php
                    $status = "0";
                    if(isset($_POST['status'])){
                        if($_POST['status'] == '0'){
                            echo"
                            <option value='0' selected=''>Đang giao hàng</option>
                            <option value='1'>Giao thành công</option>
                            <option value='2'>Đã hủy</option>";
                        }else if($_POST['status'] == '1'){
                            echo"
                            <option value='0'>Đang giao hàng</option>
                            <option value='1' selected=''>Giao thành công</option>
                            <option value='2'>Đã hủy</option>";
                        }else{
                            echo"
                            <option value='0'>Đang giao hàng</option>
                            <option value='1'>Giao thành công</option>
                            <option value='2' selected=''>Đã hủy</option>";
                        }
                        $status = $_POST['status'];
                    }else{
                        echo"
                        <option value='0'>Đang giao hàng</option>
                        <option value='1'>Giao thành công</option>
                        <option value='2'>Đã hủy</option>";
                        $status = '0';
                    }
                    ?>
                    
                </select>
            </form>
            </div>
            <table>
                <tr>
                    <th>STT</th>
                    <th>Tên người mua</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Tên sản phẩm</th>
                    <th>Màu sắc</th>
                    <th>Dung lượng</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th colspan="2">Trạng thái</th>
                </tr>
                <?php
				include 'connect_db.php';


				$sql = "SELECT * FROM orderdetails 
                INNER JOIN orderitems on orderdetails.OrderID = orderitems.OrderID 
                where orderdetails.Status = $status
                GROUP BY orderitems.OrderID";
				$result = $conn->query($sql);
				if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
                    $Total = "";
                    $dem = 0;
                    for($i = strlen($row["Total"]) - 1; $i >= 0; $i--){
                        if($dem < 2 ){
                            $Total = $Total . $row["Total"][$i];
                            $dem ++;
                        }else if($i > 0){
                            $Total = $Total . $row["Total"][$i].'.';
                            $dem = 0;
                        }else{
                            $Total = $Total . $row["Total"][$i];
                        }
                    }
                    $Total = strrev($Total);
                    $productdetailid =  $row["OrderID"];
                    $query = "select * from productdetail 
                    INNER JOIN product on productdetail.ProductID = product.ProductID 
                    INNER JOIN orderitems on productdetail.ProductDetailID = orderitems.ProductDetailID 
                    INNER JOIN color on productdetail.ColorID = color.ColorID 
                    INNER JOIN capacity on productdetail.CapacityID = capacity.CapacityID 
                    WHERE orderitems.OrderID = $productdetailid" ;
                    
                    $inforProduct = $conn->query($query);
                    if($inforProduct->num_rows > 0){
                        
                        if($inforProduct->num_rows == 1){
                            $data = $inforProduct->fetch_assoc();
                            $price = "";
                            $dem = 0;
                            for($i = strlen($data["Price"]) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price = $price . $data["Price"][$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price = $price . $data["Price"][$i].'.';
                                    $dem = 0;
                                }else{
                                    $price = $price . $data["Price"][$i];
                                }
                            }
                            $price = strrev($price);
                            ($row["Status"] == 0) ? $State = 'Đang giao' : ($row["Status"] == 1 ? $State = 'Thành công' : $State = 'đã hủy');
                            if($row['Status'] != 0){
                                echo "<tr>
                                <td>" . $row["OrderID"]. "</td>
                                <td>" . $row["CustomerName"]. "</td>
                                <td>" . $row["CustomerAddress"] . "</td>
                                <td>" . $row["CustomerPhone"]. "</td>
                                <td>" . $data["ProductName"]."</td>
                                <td>" . $data["ColorName"]. "</td>
                                <td>" . $data["CapacityName"]. "</td>
                                <td>" . $price. "</td>
                                <td>" . $row["OrderQuantity"]. "</td>
                                <td>" . $Total. "</td>
                                <td colspan='2' align='center'>" . $State. "</td>
                                </tr>";
                            }else{
                            echo "
                            <tr>
                            <td>" . $row["OrderID"]. "</td>
                            <td>" . $row["CustomerName"]. "</td>
                            <td>" . $row["CustomerAddress"] . "</td>
                            <td>" . $row["CustomerPhone"]. "</td>
                            <td>" . $data["ProductName"]."</td>
                            <td>" . $data["ColorName"]. "</td>
                            <td>" . $data["CapacityName"]. "</td>
                            <td>" . $price. "</td>
                            <td>" . $row["OrderQuantity"]. "</td>
                            <td>" . $Total. "</td>
                            <td>" . $State. "</td>
                            <td><form method='post'><button type='submit' name='id' value='".$row["OrderID"]."'>Thành công</button></form></td>
                            </tr>";
                            }
                        }else{
                            $data = $inforProduct->fetch_assoc();
                            $price = "";
                            $dem = 0;
                            for($i = strlen($data["Price"]) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price = $price . $data["Price"][$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price = $price . $data["Price"][$i].'.';
                                    $dem = 0;
                                }else{
                                    $price = $price . $data["Price"][$i];
                                }
                            }
                            $price = strrev($price);
                            ($row["Status"] == 0) ? $State = 'Đang giao' : ($row["Status"] == 1 ? $State = 'Thành công' : $State = 'đã hủy');
                            if($row["Status"] != 0){
                                echo "
                                <tr>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["OrderID"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerName"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerAddress"] . "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerPhone"]. "</td>
                                <td>" . $data["ProductName"]."</td>
                                <td>" . $data["ColorName"]. "</td>
                                <td>" . $data["CapacityName"]. "</td>
                                <td>" . $price. "</td>
                                <td>" . $row["OrderQuantity"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $Total. "</td>
                                <td rowspan='".$inforProduct->num_rows."' colspan='2' align='center'>" . $State. "</td>
                                </tr>";
                            }
                            else{
                                echo "
                                <tr>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["OrderID"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerName"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerAddress"] . "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $row["CustomerPhone"]. "</td>
                                <td>" . $data["ProductName"]."</td>
                                <td>" . $data["ColorName"]. "</td>
                                <td>" . $data["CapacityName"]. "</td>
                                <td>" . $price. "</td>
                                <td>" . $row["OrderQuantity"]. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $Total. "</td>
                                <td rowspan='".$inforProduct->num_rows."'>" . $State. "</td>
                                <td rowspan='".$inforProduct->num_rows."'><form method='post'><button type='submit' name='id' value='".$row["OrderID"]."'>Thành công</button></form></td>
                                </tr>";
                            }
                        while($data1 = $inforProduct->fetch_assoc()){
                            $price = "";
                            $dem = 0;
                            for($i = strlen($data1["Price"]) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price = $price . $data1["Price"][$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price = $price . $data1["Price"][$i].'.';
                                    $dem = 0;
                                }else{
                                    $price = $price . $data1["Price"][$i];
                                }
                            }
                            $price = strrev($price);
                            echo "
                            <tr>
                            <td>" . $data1["ProductName"]."</td>
                            <td>" . $data1["ColorName"]. "</td>
                            <td>" . $data1["CapacityName"]. "</td>
                            <td>" . $price. "</td>
                            <td>" . $row["OrderQuantity"]. "</td>
                            </tr>";
                        }
                        }
                    }
					
				}
				echo "</table>";
				} else { echo "0 tìm thấy kết quả"; }

				$conn->close();
                ?>
            </table>
        </div>
    </body>
</html>