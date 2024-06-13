<html>
	<head>
		<title>Đăng ký thành viên</title>
	</head>
	<body>
    <?php

    require_once("../connect_db.php");
    if (isset($_POST["btn_submit"])) {
    //lấy thông tin từ các form bằng phương thức POST
    $username = $_POST["username"];
    $password = $_POST["password"];
    $repassword  = $_POST["repassword"];
    $phonenumber = $_POST["phonenumber"];
    //$email = $_POST["email"];

    $email = $_POST["email"];
    
    //Kiểm tra điều kiện bắt buộc đối với các field không được bỏ trống
    if ($username == "" || $password == "" || $phonenumber == "" || $email == "") {
        echo '<div style="color: red; text-align: center;">Vui long nhập đầy đủ thông tin </div>';
    }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div style="color: red; text-align: center;">email không đúng cú pháp</div>';
    }else if(strcmp($password, $repassword) != 0){
        echo '<div style="color: red; text-align: center;">Mật khẩu nhập không khớp</div>';
    }else{
        // Kiểm tra tài khoản đã tồn tại chưa
        $sql="select * from user where UserName='$username'";
        $kt=mysqli_query($con, $sql);
        if(mysqli_num_rows($kt) > 0){
            echo '<div style="color: red; text-align: center;">Tài khoản đã tồn tại</div>';
        }else{
            
            $sql = "INSERT INTO user(UserName,Password,PhoneNumber,Email,RoleID) VALUES (
                
                '$username',
                '".md5($password)."',
                '$phonenumber',
                '$email',
                '1'
                )";
            // thực thi câu $sql với biến conn lấy từ file connection.php
            mysqli_query($con,$sql);
            echo '<script language="javascript">alert("Đăng ký thành công!"); window.location="http://localhost/Nhom9%20PHP/home/"</script>';
        }
    }
    
}
?>