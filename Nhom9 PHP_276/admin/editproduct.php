



<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->

        <title>Save product details</title>
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
                <a href="editproduct.php"><div style="border-right: 5px solid #ffd503;">cập nhật sản phẩm</div></a>
                <a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
                <a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
                <a href="addcompany.php"><div>thêm công ty</div></a>
                <a href="addcapacity.php"><div>thêm dung lượng</div></a>
                <a href="order.php"><div>đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
        <div style="margin-left: 70px; margin-top: 24px">
            <div>
            <h3>chọn sản phẩm </h3>
            <form method='POST' id='frm_product' action='editproduct.php'>
            <select name='id' OnChange='$("#frm_product").submit();'>
                <?php
                while ($row = $result->fetch_assoc()) 
                {
                    print "<option value='$row[ProductID]' >$row[ProductName]</option>";
                }
                ?>
            </select>
            <button type='submit' autofocus >chọn</button>
            </form>
            <?php
                if(!empty($_POST['id']))
                {
                        $id = $_POST['id'];
                        $result = $conn->query("SELECT * FROM product WHERE  product.ProductID=$id");
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                }
            ?>
            </div>
        <div class="form-container">

            <div class="messages">
             
            </div>

            <form  action ="editproduct1.php" method="post" enctype="multipart/form-data">
                <label for="name">ProductID</label>
                <input type="text" id="name" name="productid" value='<?php echo isset($row['ProductID'])?$row['ProductID']:'' ?>' readonly>

                <label for="name">Name</label>
                <input type="text" id="name" name="productname" value='<?php echo isset($row['ProductName'])?$row['ProductName']:'' ?>'>

                <label for="price">Price</label>
                <input type="text" id="price" name="productprice" value='<?php echo isset($row['Price'])?$row['Price']:'' ?>'>

                <label for="note">Note</label>
                <input type="text" id="note" name="note" value='<?php echo isset($row['ProductNote'])?$row['ProductNote']:''?>'>

                
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