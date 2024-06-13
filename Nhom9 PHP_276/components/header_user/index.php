<div class="header">
    <div>
    <div class="header__img">
        <a href="../user"><img src="../assets/image/logoDMX.png" alt="logo"></a>
    </div>
    <div class="header__nav-search">
            <form action="../search/search.php" method="get">
                <input type="text" name="search" placeholder="Bạn tìm gì...">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
    </div>
    <div class="header__nav">
        <div class="btn_navmobile">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="header__action">
            <a href="../Cart/index.php"><button><i class="fa-solid fa-cart-shopping" style="color: #fff;"></i>Giỏ hàng</button></a>
        </div>
        <div class="header__mobilenav-func">
            <input type="text" placeholder="Bạn tìm gì..." class="moblie_search">
            <ul>
                <li><a href="#">Xin chào <?php echo $_SESSION["username"];?></a></li>
                <li><a href="../logout/index.php">Đăng xuất</a></li>
                <li><a href="#">Phản hồi</a></li>
                <li><a href="#">Danh mục sản phẩm</a></li>
            </ul>
        </div>
        <div class="header__nav-func">
            <ul>
                <li><a href="">Danh mục sản phẩm</a>
                        <div class="header__category">
                            <ul>
                                <li><a href="../search/iphone.php?company=<?php echo "Apple" ?>">Iphone</a></li>
                                <li><a href="../search/iphone.php?company=<?php echo "SamSung" ?>">SamSung</a></li>
                                <li><a href="../search/iphone.php?company=<?php echo "Sony" ?>">Sony</a></li>
                                <li><a href="../search/iphone.php?company=<?php echo "Xiaomi" ?>">Xiaomi</a></li>
                                <li><a href="../search/iphone.php?company=<?php echo "Vivo" ?>">Vivo</a></li>
                                <li><a href="../search/iphone.php?company=<?php echo "Oppo" ?>">Oppo</a></li>
                            </ul>
                        </div>
                    </li>
                <li><a href="#"><?php echo $_SESSION["username"];?></a></li>
                <li><a href="../logout/index.php">Đăng xuất</a></li>
                <li><a href="#">Phản hồi</a></li>
            </ul>
        </div>  
    </div>
    </div>
</div>


