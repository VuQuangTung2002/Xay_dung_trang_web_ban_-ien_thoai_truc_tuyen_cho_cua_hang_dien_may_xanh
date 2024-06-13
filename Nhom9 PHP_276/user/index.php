<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../components/header_user/style.css">
    <link rel="stylesheet" href="../components/footer/style.css">
    <link rel="stylesheet" href="../components/banner/style.css">
    <link rel="stylesheet" href="../home/style.css">
</head>
<body>
    <?php
        require_once("../middleware/auth.php");
        include "../components/banner/index.php";
    ?>
    <?php include_once('../components/header_user/index.php');?>
    <div class="container">
        <!-- <div class="container__category">
            <div class="container__category-header">Danh mục sản phẩm</div>
            <ul class="container__category-content">
                <li><a href="#">Iphone</a></li>
                <li><a href="#">SamSung</a></li>
                <li><a href="#">Sony</a></li>
                <li><a href="#">Xiaomi</a></li>
                <li><a href="#">Vivo</a></li>
            </ul>
            <div style="margin-top: 12px">
                <img src="../assets/image/laptopdesk-222-340x340.jpg" alt="" width="100%">
            </div>
            <div style="margin-top: 12px">
                <img src="../assets/image/laptopdesk1111111-340x340.jpg" alt="" width="100%">
            </div>
        </div> -->
        <div class="container__product">
                <?php
                    require_once("../connect_db.php");
                    $query = "select * from product";
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
                                    echo '<div class="product__item">
                                    <a href="../detailProduct/index.php?q='.$data["ProductID"].'">
                                        <div class="product__img">
                                            <img src="'.$dataimage["image"].'"/>
                                        </div>
                                        <p>'.$data["ProductName"].'</p>
                                        <strong class="product__price">'.$price.'đ</strong>
                                        <div class="item-rate">
                                            <span>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                                <i class="fa-solid fa-star"></i>
                                            </span>
                                            <span class="rate-total">125</span>
                                        </div>
                                    </a>
                                </div>';
                            }
                        }
                    }
                ?>
        </div>
    </div>
    <?php include "../components/footer/index.php";?>
    <script src="../components/mobile.js"></script>
</body>
</html>