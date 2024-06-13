<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>
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
    
                if(isset($_SESSION['userId'])){
                    $userid = $_SESSION['userId'];
                    require_once("../connect_db.php");
                    if(isset($_POST['id']))
                    {
                        $status =  $_POST['id'];
                    $query = "select * from orderdetails INNER JOIN orderitems ON orderdetails.OrderID = orderitems.OrderID
                                                         INNER JOIN productdetail ON productdetail.ProductDetailID = orderitems.ProductDetailID
                                                         INNER JOIN product ON product.ProductID = productdetail.ProductID
                                                         INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                         INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                         where UserID = ".$userid." and Status = ".$status;
                    }
                    else
                        $query = "select * from orderdetails INNER JOIN orderitems ON orderdetails.OrderID = orderitems.OrderID
                                                         INNER JOIN productdetail ON productdetail.ProductDetailID = orderitems.ProductDetailID
                                                         INNER JOIN product ON product.ProductID = productdetail.ProductID
                                                         INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                         INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                         where UserID = ".$userid." and Status = 0";
                    $dem =0;
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($data = mysqli_fetch_assoc($result)){
                            if($dem ==0)
                            {
                                echo '<div class="cart__container">
                                      <div class="cart__header">'.$data['CustomerName'].' - '.$data['CustomerPhone'].'</div>
                                      <div class="cart__title">
                                        <form action="" id="frm_order" method="POST">
                                            <select class="selection" name="id" OnChange="ordersubmit()">
                                               
                                               ';
                                                if(isset($_POST['id'])){
                                                    if($_POST['id'] == 0)
                                                    echo '<option value="0" selected="">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                    if($_POST['id'] == 1)
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1" selected="">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                    if($_POST['id'] == 2)
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2" selected="">Đã Hủy</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                }
                                echo '
                                            </select>
                                        </form>
                                        <table>
                                            <thead>
                                                <th>Sản phẩm</th>
                                                <th>Loại hàng</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Ngày mua</th>
                                                <th>Trạng Thái</th>
                                            </thead>';
                                $dem++;
                            }
                            $price = $data['Total'];
                            $sql = "select * from productimage where productimage.ProductID = ".$data['ProductID']."";
                            $result2 = mysqli_query($con, $sql);
                            if(mysqli_num_rows($result2) > 0){
                                $dataimage = mysqli_fetch_assoc($result2);
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
                                            '.$data['OrderQuantity'].'
                                        </td>
                                        <td>'.$price.'đ</td>
                                        <td>'.$data['DateOrder'].'</td>';
                                        if($data['Status'] == 1)
                                            echo '<td>Đã nhận hàng</td>';
                                        if($data['Status'] == 2)
                                            echo '<td>Đã hủy</td>';
                                        if($data['Status'] == 0)
                                        echo '<td>Đang giao hàng</td>
                                              <td><a href = "../Cart/update_order.php?orderid='.$data['OrderID'].'"><button class="btn__delcart">Hủy đơn hàng</button></a></td>';
                                        echo '</tr>';
                            }
                        }
                        echo "</table>
                    </div>
                </div>";
                    }
                    else{
                    echo '<div class="cart__container">
                            <form action="" id="frm_order" method="POST">
                                <select class="selection" name="id" OnChange="ordersubmit()">';
                                    if(isset($_POST['id'])){
                                        if($_POST['id'] == 0)
                                            echo '<option value="0" selected="">Đang giao hàng</option>
                                                  <option value="1">Đã nhận hàng</option>
                                                  <option value="2">Đã Hủy</option>';
                                        if($_POST['id'] == 1)
                                            echo '<option value="0">Đang giao hàng</option>
                                                  <option value="1" selected="">Đã nhận hàng</option>
                                                  <option value="2">Đã Hủy</option>';
                                        if($_POST['id'] == 2)
                                            echo '<option value="0">Đang giao hàng</option>
                                                  <option value="1">Đã nhận hàng</option>
                                                  <option value="2" selected="">Đã Hủy</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="0">Đang giao hàng</option>
                                              <option value="1">Đã nhận hàng</option>
                                              <option value="2">Đã Hủy</option>';
                                    }
                    echo '
                                </select>
                            </form>
                            <div style="text-align: center;">Không có hóa đơn nào</div>
                          </div>';
                }
                }
                else{
                    require_once("../connect_db.php");
                    if(isset($_SESSION['cart']) && isset($_SESSION['color']) && isset($_SESSION['capacity'])){
                        
                        if(isset($_POST['phonenumber']))
                        {
                            $sdt = $_POST['phonenumber'];
                            $_SESSION['pn'] = $_POST['phonenumber'];
                        }
                        else
                            $sdt = $_SESSION['pn'];
                        if(isset($_POST['status']))
                        {
                            $status =  $_POST['status'];
                            $query = "select * from orderdetails INNER JOIN orderitems ON orderdetails.OrderID = orderitems.OrderID
                                                             INNER JOIN productdetail ON productdetail.ProductDetailID = orderitems.ProductDetailID
                                                             INNER JOIN product ON product.ProductID = productdetail.ProductID
                                                             INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                             INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                             Where CustomerPhone = '$sdt' and Status = '$status'";
                        }
                        else
                            $query = "select * from orderdetails INNER JOIN orderitems ON orderdetails.OrderID = orderitems.OrderID
                                                             INNER JOIN productdetail ON productdetail.ProductDetailID = orderitems.ProductDetailID
                                                             INNER JOIN product ON product.ProductID = productdetail.ProductID
                                                             INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                                                             INNER JOIN color ON color.ColorID = productdetail.ColorID 
                                                             Where CustomerPhone = '$sdt' and Status = 0";
                    $dem =0;
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        while($data = mysqli_fetch_assoc($result)){
                            if($dem ==0)
                            {
                                echo '<div class="cart__container">
                                      <div class="cart__header">'.$data['CustomerName'].' - '.$data['CustomerPhone'].'</div>
                                      <div class="cart__title">
                                        <form action="" id="frm_order" method="POST">
                                            <select class="selection" name="status" OnChange="ordersubmit()">';
                                                if(isset($_POST['status'])){
                                                    if($_POST['status'] == 0)
                                                    echo '<option value="0" selected="">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                    if($_POST['status'] == 1)
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1" selected="">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                    if($_POST['status'] == 2)
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2" selected="">Đã Hủy</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">Đang giao hàng</option>
                                                          <option value="1">Đã nhận hàng</option>
                                                          <option value="2">Đã Hủy</option>';
                                                }
                                echo '
                                            </select>
                                        </form>
                                        <table>
                                            <thead>
                                                <th>Sản phẩm</th>
                                                <th>Loại hàng</th>
                                                <th>Số lượng</th>
                                                <th>Đơn giá</th>
                                                <th>Ngày mua</th>
                                                <th>Trạng thái</th>
                                            </thead>';
                                $dem++;
                            }
                            $price = $data['Total'];
                            $sql = "select * from productimage where productimage.ProductID = ".$data['ProductID']."";
                            $result2 = mysqli_query($con, $sql);
                            if(mysqli_num_rows($result2) > 0){
                                $dataimage = mysqli_fetch_assoc($result2);
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
                                            '.$data['OrderQuantity'].'
                                        </td>
                                        <td>'.$price.'đ</td>
                                        <td>'.$data['DateOrder'].'</td>';
                                        if($data['Status'] == 1)
                                            echo '<td>Đã nhận hàng</td>';
                                        if($data['Status'] == 2)
                                            echo '<td>Đã hủy</td>';
                                        if($data['Status'] == 0)
                                        echo '<td>Đang giao hàng</td>
                                              <td><a href = "../Cart/update_order.php?orderid='.$data['OrderID'].'"><button class="btn__delcart">Hủy đơn hàng</button></a></td>';
                                        echo '</tr>';
                            }
                        }
                        echo "</table>
                        </div>
                    </div>";
                    }
                    else{
                    echo '<div class="cart__container">
                            <form action="" id="frm_order" method="POST">
                                <select class="selection" name="id" OnChange="ordersubmit()">';
                                    if(isset($_POST['status'])){
                                        if($_POST['status'] == 0)
                                            echo '<option value="0" selected="">Đang giao hàng</option>
                                                  <option value="1">Đã nhận hàng</option>
                                                  <option value="2">Đã Hủy</option>';
                                        if($_POST['status'] == 1)
                                            echo '<option value="0">Đang giao hàng</option>
                                                  <option value="1" selected="">Đã nhận hàng</option>
                                                  <option value="2">Đã Hủy</option>';
                                        if($_POST['status'] == 2)
                                            echo '<option value="0">Đang giao hàng</option>
                                                  <option value="1">Đã nhận hàng</option>
                                                  <option value="2" selected="">Đã Hủy</option>';
                                    }
                                    else
                                    {
                                        echo '<option value="0">Đang giao hàng</option>
                                              <option value="1">Đã nhận hàng</option>
                                              <option value="2">Đã Hủy</option>';
                                    }
                    echo '
                                </select>
                            </form>
                            <div style="text-align: center;">Không có hóa đơn nào</div>
                          </div>';
                }
                }
            }
            
            ?>
        <script type="text/javascript">
            function ordersubmit() {
                document.getElementById('frm_order').submit();
            }
        </script>
</body>
</html>