<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="../components/header/style.css">
</head>
<body>
    <?php 
        require_once("../connect_db.php");
        session_start();
        if(!isset($_SESSION["userId"]) || !isset($_SESSION["username"])){
            include_once("../components/header/index.php");
        }else{
            $sess_userId = $_SESSION["userId"];
            $sess_username = $_SESSION["username"];
            $query = "select * from user where UserID = '$sess_userId' and UserName = '$sess_username'";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result) > 0){
                $data = mysqli_fetch_assoc($result);
            }
            if($_SESSION["userId"] != $data["UserID"] || $_SESSION["username"] != $data["UserName"]){
                include_once("../components/header/index.php");
            }else{
                include_once("../components/header_user/index.php");
            }
        }
    ?>
    <div class="cart__container">
        <div class="cart__header">Danh sách sản phẩm</div>
        <div class="cart__title">
            <!-- <div style="padding: 0px 80px 0px 140px">Sản Phẩm</div>
            <div>Loại Hàng</div>
            <div>Số Lượng</div>
            <div>Đơn Giá</div>
            <div>Thao Tác</div>
        </div> -->
            <table>
                <thead>
                    <th>Sản phẩm</th>
                    <th>Loại hàng</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thao tác</th>
                </thead>
            <?php
                if(isset($_SESSION['userId'])){
                    $userid = $_SESSION['userId'];
                    require_once("../connect_db.php");
                    $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID
                                                    INNER JOIN cartitem ON productdetail.ProductDetailID = cartitem.ProductDetailID 
                                                    INNER JOIN color ON productdetail.ColorID = color.ColorID 
                                                    INNER JOIN capacity ON productdetail.CapacityID = capacity.CapacityID 
                                                    where UserID = ".$userid;
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($data = mysqli_fetch_assoc($result)){
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
                            $sql = "select * from productimage where productimage.ProductID = ".$data['ProductID']."";
                            $result2 = mysqli_query($con, $sql);
                            if(mysqli_num_rows($result2) > 0){
                                $dataimage = mysqli_fetch_assoc($result2);
                                $quantity = $data['CartQuantity'];
                                if(isset($_GET['index1']) && $quantity > 1 && $data['CartID'] == $_GET['index1']){
                                    $quantity -= 1;
                                }
                                if(isset($_GET['index2']) && $data['CartID'] == $_GET['index2'] && $quantity < $data['Quantity']){
                                    $quantity += 1;
                                }
                                $sql1 = "UPDATE cartitem SET CartQuantity = ".$quantity." where CartID = ".$data['CartID'];
                                mysqli_query($con,$sql1);
                                    echo '
                                        <tr>
                                        <td class="cart__product">
                                            <img src="'.$dataimage["image"].'" width = 80px/>
                                            <div>'.$data["ProductName"].'</div>
                                        </td>
                                        <td>
                                            Phân loại hàng: <br>
                                            '.$data['CapacityName'].'<br>
                                            '.$data['ColorName'].'<br>
                                        </td>
                                        <td>
                                            <a href ="index.php?index1='.$data['CartID'].'"><button><img src="../assets/image/iconminus.png" width = 10px/></button></a>
                                             '.$quantity.'
                                            <a href ="index.php?index2='.$data['CartID'].'"><button><img src="../assets/image/iconplus.png" width = 10px/></button></a>

                                        </td>
                                        <td>'.$price.'đ</td>
                                        <td>
                                        <a href = "../Cart/delete_cart.php?cartID='.$data['CartID'].'"><button class="btn__delcart">Xóa khỏi giỏ hàng</button></a>
                                        </td>
                                        </tr>';
                            }
                        }
                    }
                    echo "</table>".
                            '<div class="cart__footer">';
                            if(mysqli_num_rows($result) > 0)
                            {
                                echo'
                                    <div style="width: 200px;">
                                        <button class="btn__order">Mua hàng</button>
                                    </div>';
                            }
                            echo'
                            <div>
                                <button class= "btn__order1"><a href ="index_order.php">Hóa đơn</a></button>
                            </div>
                            </div>';
                }
                else{
                    require_once("../connect_db.php");
                    if(isset($_SESSION['cart']) && isset($_SESSION['color']) && isset($_SESSION['capacity'])){
                        for($j = count($_SESSION['cart'])-1; $j>=0; $j--){
                    $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID 
                                                    INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                    INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                    WHERE productdetail.ProductDetailID =".$_SESSION['cart'][$j];
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($data = mysqli_fetch_assoc($result)){
                            $price = "";
                            $dem = 0;
                            for($i = strlen($data["Price"]) - 1; $i >= 0; $i--){
                                if($i % 3 == 2 && $dem < 2){
                                    $price = $price . $data["Price"][$i].'.';
                                    $dem ++;
                                }else{
                                    $price = $price . $data["Price"][$i];
                                }
                            }
                            $price = strrev($price);
                            $sql = "select * from productimage where productimage.ProductID = ".$data['ProductID']."";
                            $result2 = mysqli_query($con, $sql);
                            if(mysqli_num_rows($result2) > 0){
                                $dataimage = mysqli_fetch_assoc($result2);
                                if(isset($_GET['index1']) && $_SESSION['quantity'][$j]>1 && $j == $_GET['index1']){
                                    $_SESSION['quantity'][$j] -= 1;
                                }
                                if(isset($_GET['index2']) && $j == $_GET['index2'] && $_SESSION['quantity'][$j] < $data['Quantity']){
                                    $_SESSION['quantity'][$j] += 1;
                                }
                                    echo '
                                        <tr>
                                        <td class="cart__product">
                                            <img src="'.$dataimage["image"].'" width = 80px/>
                                            <div>'.$data["ProductName"].'</div>
                                        </td>
                                        <td>
                                            Phân loại hàng: <br>
                                            '.$data['CapacityName'].'<br>
                                            '.$data['ColorName'].'<br>
                                        </td>
                                        <td>
                                            <a href ="index.php?index1='.$j.'"><button><img src="../assets/image/iconminus.png" width = 10px/></button></a>
                                            '.$_SESSION['quantity'][$j].'
                                            <a href ="index.php?index2='.$j.'"><button><img src="../assets/image/iconplus.png" width = 10px/></button></a>
                                        </td>
                                        <td>'.$price.'đ</td>
                                        <td>
                                        <a href = "../Cart/delete_cart.php?cartID='.$data['ProductDetailID'].'"><button class="btn__delcart">Xóa khỏi giỏ hàng</button></a>
                                        </td>
                                        </tr>';
                            }
                        }
                        
                    }
                    }
                }
                echo "</table>".
                '<div class="cart__footer">';
                if(isset($_SESSION['cart']) && $_SESSION['cart'] != null)
                {
                    echo'
                    <div style="width: 200px;">
                        <button class="btn__order">Mua hàng</button>
                    </div>';
                }
                    echo'
                    <div>
                        <button class="order">Hóa đơn</button>
                    </div>
                </div>';
            }
            ?>
        

        <div class="cart__wrap">
        <div class="cart__box">
            <div class="box__close"><i class="fa-solid fa-xmark"></i></div>
            
                <?php
                if(isset($_SESSION['userId'])){
                    $sumPrice = 0;
                    $sql = "select * from productdetail 
                    inner join product on productdetail.ProductID = product.ProductID
                    inner join cartitem on cartitem.ProductDetailID = productdetail.ProductDetailID
                    inner join color on productdetail.ColorID = color.ColorID
                    inner join capacity on productdetail.CapacityID = capacity.CapacityID
                    where UserID = ".$_SESSION['userId']."";
                    $getCart = mysqli_query($con, $sql);
                    if(mysqli_num_rows($getCart) > 0){
                        while($row = mysqli_fetch_assoc($getCart)){
                            $sql2 = "select * from productimage where ProductID = ".$row["ProductID"]."";
                            $getImagePro = mysqli_query($con,$sql2);
                            $imageLink = mysqli_fetch_assoc($getImagePro);
                            $price = "";
                            $dem = 0;
                            for($i = strlen($row["Price"]) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price = $price . $row["Price"][$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price = $price . $row["Price"][$i].'.';
                                    $dem = 0;
                                }else{
                                    $price = $price . $row["Price"][$i];
                                }
                            }
                            $price = strrev($price);
                            $sumPrice += ($row["Price"] * $row["CartQuantity"]);
                            echo "<div class='box__title'>
                                <img src ='".$imageLink["image"]."' style='width: 60px'/>
                                <div>
                                <div>".$row["ProductName"]."</div>
                                <div>".$row["ColorName"]."</div>
                                <div>".$row["CapacityName"]."</div>
                                </div>
                                <div class='box__right'>
                                <div style='color: red;'>".$price." đ</div>
                                <div>Số lượng : ".$row["CartQuantity"]."</div>
                                </div>
                            </div>
                            ";
                        }
                        $price1 = "";
                            $dem = 0;
                            settype($sumPrice, "String");
                            for($i = strlen($sumPrice) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price1 = $price1 . $sumPrice[$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price1 = $price1 . $sumPrice[$i].'.';
                                    $dem = 0;
                                }else{
                                    $price1 = $price1 . $sumPrice[$i];
                                }
                        }
                        $price1 = strrev($price1);
                        echo "<div class='sum__price'>
                        <div>Tổng tiền (tạm tính):</div> 
                        <div style='flex: 1; text-align: right; color: red;'>$price1 đ</div>
                        </div>";
                    }
                    
                }else{
                    if(isset($_SESSION['cart']) && isset($_SESSION['color']) && isset($_SESSION['capacity'])){
                        $sumPrice = 0;
                    for($j = count($_SESSION['cart'])-1; $j>=0; $j--){
                    $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID 
                                                    INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                    INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                    WHERE productdetail.ProductDetailID =".$_SESSION['cart'][$j];
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($data = mysqli_fetch_assoc($result)){
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
                            $sql = "select * from productimage where productimage.ProductID = ".$data['ProductID']."";
                            $result2 = mysqli_query($con, $sql);
                            if(mysqli_num_rows($result2) > 0){
                                $dataimage = mysqli_fetch_assoc($result2);
                                $sumPrice += ($data["Price"] * $_SESSION['quantity'][$j]);
                                echo "<div class='box__title'>
                                    <img src ='".$dataimage["image"]."' style='width: 60px'/>
                                    <div>
                                    <div>".$data["ProductName"]."</div>
                                    <div>".$data["ColorName"]."</div>
                                    <div>".$data["CapacityName"]."</div>
                                    </div>
                                    <div class='box__right'>
                                    <div style='color: red;'>".$price." đ</div>
                                    <div>Số lượng : ".$_SESSION['quantity'][$j]."</div>
                                    </div>
                                </div>
                                ";
                            }
                        }
                        $price1 = "";
                            $dem = 0;
                            settype($sumPrice, "String");
                            for($i = strlen($sumPrice) - 1; $i >= 0; $i--){
                                if($dem < 2 ){
                                    $price1 = $price1 . $sumPrice[$i];
                                    $dem ++;
                                }else if($i > 0){
                                    $price1 = $price1 . $sumPrice[$i].'.';
                                    $dem = 0;
                                }else{
                                    $price1 = $price1 . $sumPrice[$i];
                                }
                        }
                        $price1 = strrev($price1);
                        echo "<div class='sum__price'>
                        <div>Tổng tiền (tạm tính):</div> 
                        <div style='flex: 1; text-align: right; color: red;'>$price1 đ</div>
                        </div>";
                        
                    }
                    }
                }
                }
                ?>
            <form action="add_order.php" method="post">
                <div class="info__container">
                    <div class="info__title">Thông tin khách hàng</div>
                    <div class="info__content">
                        <input type="text" name="name" placeholder="Họ và tên">
                        <input type="text" name="phonenumber" placeholder="Số điện thoại">
                        <input type="text" name="address" placeholder="Địa chỉ" class="info__address">
                    </div>
                </div>
                <div class="method__pay">
                    <div>Phương thức thanh toán : tiền mặt</div>
                </div>
                <div class="info_btn">
                    <button type="submit">ĐẶT MUA</button>
                </div>
                </div>
                
            </form>
        </div>
        </div>

        <div class="cart__wrap1">
        <div class="cart__box1">
            <div class="box__close1"><i class="fa-solid fa-xmark"></i></div>
            <div class="box__title1">Nhập số điện thoại của bạn</div>
            <form action="index_order.php" method="post">
                <table>
                    <tr>
                        <td><label>Số điện thoại</label></td>
                        <td><input type="text" name="phonenumber"><br></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Gửi</button></td>
                    </tr>
                </table>
            </form>
        </div>
        </div>

    </div>
    <script src="../components/mobile.js"></script>
    <script>
        var btnOrder = document.querySelector(".btn__order");
        var cartBox = document.querySelector(".cart__box");
        var cartWrap = document.querySelector(".cart__wrap");
        var boxClose = document.querySelector(".box__close");
        btnOrder.addEventListener("click",()=>{
            cartBox.classList.add("show");
            cartWrap.classList.add("show");
        })
        boxClose.addEventListener("click",()=>{
            cartWrap.classList.remove("show");
            cartBox.classList.remove("show");
        })
    </script>
    <script src="../components/mobile.js"></script>
    <script>
        var btnOrder1 = document.querySelector(".order");
        var cartBox1 = document.querySelector(".cart__box1");
        var cartWrap1 = document.querySelector(".cart__wrap1");
        var boxClose1 = document.querySelector(".box__close1");
        btnOrder1.addEventListener("click",()=>{
            cartBox1.classList.add("show");
            cartWrap1.classList.add("show");
        })
        boxClose1.addEventListener("click",()=>{
            cartWrap1.classList.remove("show");
            cartBox1.classList.remove("show");
        })
    </script>
    
</body>
</html>