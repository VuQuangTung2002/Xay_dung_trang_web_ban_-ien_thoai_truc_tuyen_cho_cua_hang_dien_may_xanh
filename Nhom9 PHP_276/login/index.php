<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="wrap">
        <div class="login__icon">
            <i class="fa-solid fa-unlock-keyhole"></i>
        </div>
        <div class="login__title">
            Đăng nhập
        </div>
        <?php require 'handle.php';?>
        <form action="index.php" method="POST">
            <div style="position: relative;">
                <input type="text" name="username"  class="input form-input">
                <div class="placeholder">Tên đăng nhập</div>
            </div>
            <div style="position: relative;">
                <input type="password" name="password"  class="input form-input">
                <div class="placeholder">Mật khẩu</div>
            </div>
            
            <button type="submit"  name="btn_submit">Đăng nhập</button>
            <div class="redirect__link">
                <a href="#">Quên mật khẩu?</a>
                <a href="../register/index.php">Bạn chưa có tài khoản? Đăng kí?</a>
            </div>
        </form>
    </div>
    <script>
        const inputs = document.querySelectorAll('.form-input');
        console.log(inputs);
        inputs.forEach(input => {
            input.addEventListener('blur', (event) => {
            if (event.target.value.length) {
                event.target.classList.add("full");
            } else {
                event.target.classList.remove("full");
            }
        });
        })
        
    </script>
</body>
</html>