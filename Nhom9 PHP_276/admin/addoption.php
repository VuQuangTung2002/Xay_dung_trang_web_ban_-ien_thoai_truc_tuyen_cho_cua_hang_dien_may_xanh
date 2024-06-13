<?php

include 'connect_db.php';
session_start();

    if(isset($_POST['show'])){
        header('Location: show_product.php');
    }
    else 
        if( !empty($_POST['productcolor']) && !empty($_POST['productcapacity']) && !empty($_POST['productscreen']) && !empty($_POST['productos']) 
        && !empty($_POST['productcam']) && !empty($_POST['productchip']) && !empty($_POST['productpin']) 
        && !empty($_POST['productcompany']) && !empty($_POST['productquantity']) )
    {
        //insert product
        $ProductID =$_SESSION["productid"];
        $productcolor = $_POST['productcolor'];
        $productcapacity  = $_POST['productcapacity'];
        $productscreen  = $_POST['productscreen'];
        $productos  = $_POST['productos'];
        $productcam  = $_POST['productcam'];
        $productchip  = $_POST['productchip'];
        $productpin  = $_POST['productpin'];
        $productcompany  = $_POST['productcompany'];
        $productquantity = $_POST['productquantity'];
        $date = date('Y-m-d H:i:s');



            //insert productdetail
            $sql ="INSERT INTO productdetail (ProductID,ColorID,CapacityID,Quantity,ProductScreen,ProductOS,ProductCam,ProductChip,ProductPin,CompanyID,Date) VALUES('$ProductID','$productcolor','$productcapacity','$productquantity','$productscreen','$productos','$productcam','$productchip','$productpin','$productcompany','$date')";
            $sq= mysqli_query($conn,$sql);
            header('Location:show_option.php');

    }
    elseif (!empty($_POST['submit_id'])) {

    $message = "Vui lòng điền đầy đử thông tin!";
echo "<script type='text/javascript'>alert('$message');</script>";

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
                <a href="addcompany.php"><div>thêm công ty</div></a>
                <a href="addoption.php"><div style="border-right: 5px solid #ffd503;">thêm dung lượng</div></a>
                <a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
                <a href="order.php"><div>đơn hàng</div></a>
                <a href="analysis.php"><div>Thống kê doanh thu</div></a>
            </div>
            <div class="form-container">
            <div class="messages">
            </div>
                <?php 
                $productid =$_SESSION["productid"];
                    $sql = "select * from  product WHERE ProductID =$productid";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo "<h2>Thêm option cho: ".$data["ProductName"] ."</h2>";
                            }
                        }
                    echo '<br>';
                ?>
                <form action="addoption.php" method="post" enctype="multipart/form-data">


                <label for="color">Màu</label>
                <select name="productcolor" id="color">
                    <?php
                    
                        $sql = "select * from  color";
                        $result = mysqli_query($conn, $sql);
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
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$data["CapacityID"].'">'.$data["CapacityName"].'</option>';
                            }
                        }
                    ?>
                </select>

                                <label for="sl">Số lượng</label>
                <input type="number" id="sl" name="productquantity" >

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
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($data = mysqli_fetch_assoc($result)){
                                echo '<option value="'.$data["CompanyID"].'">'.$data["CompanyName"].'</option>';
                            }
                        }
                    ?>
                </select>

                <div>
                    <button type="submit" id="submit" value="<?php echo 1;   ?>" name="submit_id" class="button">
                    Thêm option
                </button>
                <button type="submit" id="submit1" name="show" class="button">
                    danh sách sản phẩm
                </button>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>