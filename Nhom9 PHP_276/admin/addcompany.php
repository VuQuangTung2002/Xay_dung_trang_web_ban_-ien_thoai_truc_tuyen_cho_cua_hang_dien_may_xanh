<?php

include 'connect_db.php';

        if( !empty($_POST['companyname']) && !empty($_POST['companydetail']) )
    {
        //insert 
        $companyname =$_POST["companyname"];
        $companydetail = $_POST['companydetail'];

            //insert 
			$sql ="INSERT INTO company( CompanyName,CompanyDetail) VALUES ('$companyname','$companydetail')";	
            $sq= mysqli_query($conn,$sql);

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
        <title>Save product details</title>
        <style type="text/css">
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
            input
            {
                    display: block;
    margin-bottom: 15px;
    padding-left: 4px;
    height: 30px;
    width: 300px;
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
                <a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
                <a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
                <a href="addcompany.php"><div style="border-right: 5px solid #ffd503;">thêm công ty</div></a>
                <a href="addcapacity.php"><div>thêm dung lượng</div></a>
                <a href="order.php"><div>đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
            <div class="form-container">
            <div class="messages">
            </div>

            	<table>
            		<tr>
            			<th>STT</th>
            			<th>Tên</th>
                        <th>Mô tả</th>
            		</tr>
            		<?php
            		include 'connect_db.php';

            		$sql = "SELECT * FROM company";

            		$result = $conn->query($sql);
            		$stt=1;
            		 while($row = $result->fetch_assoc()){
            		 	echo "<tr><td>".$stt++."</td><td>".$row['CompanyName']."</td><td>".$row['CompanyDetail'].
            		 	"</td></tr>";
            		 }

            		?>

            	</table>

                <form action="addcompany.php" method="post" enctype="multipart/form-data">

                <label for="ten">Tên công ty</label>
                <input type="text" id="ten" name="companyname" >

                <label for="mt">Mô tả</label>
                <input type="text" id="mt" name="companydetail" >

                <div>
                    <button type="submit" id="submit" name="submit" class="button">
                    Thêm 
                </button>

                </div>
                </form>

            </div>
        </div>
    </body>
</html>