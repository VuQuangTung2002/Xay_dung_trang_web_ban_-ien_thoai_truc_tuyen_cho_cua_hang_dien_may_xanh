<?php

include 'connect_db.php';

        if( !empty($_POST['capacityname'])  )
    {
        //insert 
        $capacityname =$_POST["capacityname"];

            //insert 
			$sql ="INSERT INTO capacity(CapacityName) VALUES ('$capacityname')";	
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
                <a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
                <a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
                <a href="addcompany.php"><div>thêm công ty</div></a>
                <a href="addcapacity.php"><div style="border-right: 5px solid #ffd503;">thêm dung lượng</div></a>
                <a href="order.php"><div>đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
            <div class="form-container">
            <div class="messages">
            </div>

            	<table>
            		<tr>
            			<th>STT</th>
            			<th>Dung lượng</th>
            		</tr>
            		<?php
            		include 'connect_db.php';

            		$sql = "SELECT * FROM capacity";

            		$result = $conn->query($sql);
            		$stt=1;
            		 while($row = $result->fetch_assoc()){
            		 	echo "<tr><td>".$stt++."</td><td>".$row['CapacityName'].
            		 	"</td></tr>";
            		 }

            		?>

            	</table>

                <form action="" method="post" enctype="multipart/form-data">

                <label for="capacity">Dung lượng</label>
                <input type="text" id="capacity" name="capacityname" >


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