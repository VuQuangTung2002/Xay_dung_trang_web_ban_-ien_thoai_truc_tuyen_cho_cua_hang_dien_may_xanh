<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="banner">
        <div class="banner__img">
            <img src="../assets/image/DMX-Desk-MHD-1920x450.jpg" alt="">
        </div>
        <div class="banner__slide">
            <div class="slide__wrap">
                <div class="slide__item active">
                    <img src="../assets/image/720-220-720x220-157.png">
                </div>
                <div class="slide__item active">
                    <img src="../assets/image/flip3-720-220-720x220.png" alt="">
                </div>
                <div class="slide__item">
                    <img src="../assets/image/flip3-720-220-720x220.png" alt="">
                </div>
                <div class="slide__item">
                    <img src="../assets/image/720-220-720x220-187.png" alt="">
                </div>
                <div class="slide__item">
                    <img src="../assets/image/720-220-720x220-162.png" alt="">
                </div>
                <div class="slide__item active">
                    <img src="../assets/image/flip3-720-220-720x220.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="banner__tag">
        <div>
            <img src="../assets/image/Frame46553-80x92.png" alt="">
            Chỉ Giảm online
        </div>
        <div>
            <img src="../assets/image/Frame46554-81x85-1.png" alt="">
            Đồng giá 99K
        </div>
        <div>
            <img src="../assets/image/Frame46555-85x86-1.png" alt="">
            Xả hàng giảm sốc
        </div>
    </div>
    <script>
        var bannerSlide = document.querySelector(".banner__slide");
        console.log(bannerSlide);
        var slideItems = document.querySelectorAll(".slide__item");
        function settime(){
            if(bannerSlide.scrollLeft < (1200 + 600 * (slideItems.length - 4))){
                bannerSlide.scrollLeft += 1200;
                console.log(bannerSlide.scrollLeft);
            }
            else{
                bannerSlide.scrollLeft -= (1200 + 600 * (slideItems.length - 4));
                console.log(bannerSlide.scrollLeft);
            }
        }
        let run = setInterval(settime, 2000);
        
        
    </script>
</body>
</html>