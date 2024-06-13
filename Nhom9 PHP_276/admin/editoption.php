



<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->

        <title></title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="../components/header_admin/style.css">
        <style type="text/css">
            

            .form-container {
                margin: 0 !important;
            }

            .form-container .messages {
                margin-bottom: 15px;
            }

            .form-container input[type="text"],
            .form-container input[type="number"] {
                display: block;
                margin-bottom: 15px;
                width: 300px;
            }

            .form-container input[type="file"] {
                margin-bottom: 15px;
            }

            .form-container label {
                display: inline-block;
                float: left;
                width: 100px;
            }

            button {
                margin: 10px;
                padding: 5px 10px;
                background-color: #8daf15;
                color: #fff;
                border: none;
            }

            .form-container .link-to-product-details {
                margin-top: 20px;
                display: inline-block;
            }
        </style>

    </head>
    <body>
        <?php
            include 'connect_db.php';
            
            
            $result = $conn->query("select ProductID , ProductName from product");
        ?>
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
        <div style="margin-left: 70px; margin-top: 24px">
            <div>
            <h3> </h3>
            <form method='POST' id='frm_product' action='editproduct.php'>
           
            </form>
            <?php

                if(!empty($_POST['id']))
                {
                        $id = $_POST['id'];//product detail id
                        $result = $conn->query("SELECT * FROM productdetail WHERE  productdetail.ProductDetailID=$id");
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                }
            ?>
            </div>
        <div class="form-container">

            <div class="messages">
             
            </div>

            <form  action ="editoption1.php" method="post" enctype="multipart/form-data">
                <label for="name">Option id:</label>
                <input type="text" id="name" name="productdetailid" value='<?php echo isset($row['ProductDetailID'])?$row['ProductDetailID']:'' ?>' readonly>

                <label for="color">Color</label>
                <input type="number" id="color" name="productcolor" value='<?php echo $row['ColorID']?>'>

                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="productcapacity" value='<?php echo $row['CapacityID']?>'>

                <label for="screen">Screen</label>
                 <input type="text" id="screen" name="productscreen" value='<?php echo isset($row['ProductScreen'])?$row['ProductScreen']:'' ?>'>


                <label for="os">OS</label>
                 <input type="text" id="os" name="productos" value='<?php echo isset($row['ProductOS'])?$row['ProductOS']:'' ?>'>


                <label for="cam">Camera</label>
                <input type="text" id="cam" name="productcam" value='<?php echo isset($row['ProductCam'])?$row['ProductCam']:'' ?>'>

                <label for="chip">Chip</label>
                <input type="text" id="chip" name="productchip" value='<?php echo isset($row['ProductChip'])?$row['ProductChip']:'' ?>'>

                <label for="pin">Pin</label>
                <input type="text" id="pin" name="productpin" value='<?php echo isset($row['ProductPin'])?$row['ProductPin']:''?>'>

                <label for="company">Company</label>
                <input type="number" id="company" name="productcompany" value='<?php echo $row['CompanyID']?>'>

                <label for="file">Images</label>

                
                <input type="file" id="file" name="file[]" multiple>
                <div>
                    <button type="submit" id="submit" name="submit" class="button">
                    Cập nhật
                </button>
                <button type="submit" name="show">Danh sách sản phẩm</button>
                </div>
                
            </form>

            
        </div>
    <div>
    </body>
</html>