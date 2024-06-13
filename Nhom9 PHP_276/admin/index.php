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
        <?php require_once("../middleware/authadmin.php")?>
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
                <a href="order.php"><div>đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
            <div class="form-container">
            <div class="messages">
            </div>

                <form action="addproduct.php" method="post" enctype="multipart/form-data">

                <label for="name">Tên</label>
                <input type="text" id="name" name="productname" >

                <label for="price">Giá</label>
                <input type="text" id="price" name="productprice" >

                <label for="note">Mô tả</label>
                <textarea id="note" name="note"></textarea>

                <label for="color">Màu</label>
                <select name="productcolor" id="color">
                    <?php
                        include 'connection.php';
                        $sql = "select * from  color";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$data["ColorID"].'">'.$data["ColorName"].'</option>';
                            }
                        }
                    ?>
                </select>

                <label for="capacity">Dung lượng</label>
                <select name="productcapacity" id="capacity">
                    <?php
                        $sql = "select * from  capacity";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$data["CapacityID"].'">'.$data["CapacityName"].'</option>';
                            }
                        }
                    ?>
                </select>

                <label for="screen">Màn hình</label>
                <input type="text" id="screen" name="productscreen" >


                <label for="os">Hệ điều hành</label>
                <input type="text" id="os" name="productos" >


                <label for="cam">Camera</label>
                <input type="text" id="cam" name="productcam" >

                <label for="chip">Chip</label>
                <input type="text" id="chip" name="productchip" >

                <label for="pin">Pin</label>
                <input type="text" id="pin" name="productpin" >

                <label for="company">Công ty</label>
                <select name="productcompany" id="company">
                    <?php
                        $sql = "select * from  company";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$data["CompanyID"].'">'.$data["CompanyName"].'</option>';
                            }
                        }
                    ?>
                </select>

                <label for="file">Ảnh sản phẩm</label>
                <input type="file" id="file" name="file[]" multiple>
                <div>
                    <button type="submit" id="submit" name="submit" class="button">
                    Submit
                </button>
                <button type="submit" id="submit1" name="show" class="button">
                    Show
                </button>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>