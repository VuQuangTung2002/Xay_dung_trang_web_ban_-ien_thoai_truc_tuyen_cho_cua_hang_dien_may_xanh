<?php 
	session_start();
	require_once("../connect_db.php");
	$name = $_POST['name'];
	$address = $_POST['address'];
	$phonenumber = $_POST['phonenumber'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time = date("Y/m/d H:i:s");
	if(isset($_SESSION['userId'])){
        $userid = $_SESSION['userId'];
        require_once("../connect_db.php");
        $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID
                                        INNER JOIN cartitem ON productdetail.ProductDetailID = cartitem.ProductDetailID 
                                        INNER JOIN color ON productdetail.ColorID = color.ColorID 
                                        INNER JOIN capacity ON productdetail.CapacityID = capacity.CapacityID 
                                        where UserID = ".$userid;
        $result = mysqli_query($con, $query);
        $price = 0;
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                    $quantity = $data['CartQuantity'];
                    $price += $data['Price'] * $quantity;
                }
                $sql = "INSERT INTO orderdetails(UserID,Total,CustomerName,CustomerPhone,CustomerAddress,DateOrder) VALUE('$userid','$price','$name','$phonenumber','$address','$time')";
                mysqli_query($con, $sql);
            }
        $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID
                                        INNER JOIN cartitem ON productdetail.ProductDetailID = cartitem.ProductDetailID 
                                        INNER JOIN orderdetails ON orderdetails.UserID = cartitem.UserID 
                                        where cartitem.UserID = ".$userid." AND OrderID = (select max(OrderID) FROM orderdetails)";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
            while($data = mysqli_fetch_assoc($result)){
                    $quantity = $data['CartQuantity'];
                    $price = $data['Price'] * $quantity;
                    
                    $orderid = $data['OrderID'];
                    $productdetailid = $data['ProductDetailID'];
                    $sql = "INSERT INTO orderitems(OrderID,ProductDetailID,OrderQuantity) VALUE('$orderid','$productdetailid','$quantity')";
                    mysqli_query($con, $sql);
                    $sql1 = "Update productdetail SET Quantity = Quantity - $quantity WHERE ProductDetailID = $productdetailid";
                    mysqli_query($con, $sql1);
                }
            }
        $query = "DELETE FROM cartitem";
        mysqli_query($con, $query);
    }else{
            if(isset($_SESSION['cart']) && isset($_SESSION['color']) && isset($_SESSION['capacity'])){
                $tong = 0;
                for($j = count($_SESSION['cart'])-1; $j>=0; $j--){
                    $query = "select * from product INNER JOIN productdetail ON product.ProductID = productdetail.ProductID 
                        INNER JOIN capacity ON capacity.CapacityID = productdetail.CapacityID
                        INNER JOIN color ON color.ColorID = productdetail.ColorID 
                        WHERE productdetail.ProductDetailID =".$_SESSION['cart'][$j];
                    $result = mysqli_query($con, $query);
                    if(mysqli_num_rows($result) > 0){
                        $data = mysqli_fetch_assoc($result);
                        $tong += $data["Price"] * $_SESSION['quantity'][$j];
                    }
                }
                $sql=" insert into orderdetails (Total, CustomerName, CustomerPhone,CustomerAddress,DateOrder) value ('$tong','$name','$phonenumber','$address','$time')";
                mysqli_query($con, $sql);
             }
            $query = "select max(OrderID) FROM orderdetails";
            $result = mysqli_query($con, $query);
            if(mysqli_num_rows($result) > 0){
                $orderIdGuest = mysqli_fetch_assoc($result);
            }
            $orderid = $orderIdGuest["max(OrderID)"];
            for($j = count($_SESSION['cart'])-1; $j>=0; $j--){
                $productdetailid = $_SESSION['cart'][$j];
                $quantity = $_SESSION['quantity'][$j];
                $sql = "INSERT INTO orderitems(OrderID,ProductDetailID,OrderQuantity) VALUE('$orderid','$productdetailid','$quantity')";
                mysqli_query($con, $sql);
                $sql1 = "Update productdetail SET Quantity = Quantity - $quantity WHERE ProductDetailID = $productdetailid";
                mysqli_query($con, $sql1);
            }
        unset($_SESSION['cart']);
        unset($_SESSION['quantity']);
        unset($_SESSION['color']);
        unset($_SESSION['capacity']);
    }
    echo '<script language="javascript">window.location="http://localhost/Nhom9%20PHP/Cart/index.php"</script>';
?>