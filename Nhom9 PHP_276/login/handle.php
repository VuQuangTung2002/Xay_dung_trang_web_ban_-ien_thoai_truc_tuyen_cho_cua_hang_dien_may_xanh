<?php
    require_once("../connect_db.php");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($username == "" || $password == ""){
            echo '<div style="text-align:center; color: red">Vui lòng điền đầy đủ thông tin<div>';
        }else{
            $sql="select * from user where UserName='$username' and Password='".md5($password)."'";
            $kt=mysqli_query($con, $sql);
            if(mysqli_num_rows($kt) == 0){
                echo '<div style="color: red; text-align: center;">Sai tên người dùng hoặc mật khẩu</div>';
            }else{
                session_start();
                $row = mysqli_fetch_assoc($kt);
                $userId = $row["UserID"];
                $role = $row["RoleID"];
                $_SESSION['userId'] = $userId;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                //echo '<script language="javascript">window.location="http://localhost/Nhom9%20PHP/user"</script>';
                if($username == "admin" || $role == "0"){
                    header('Location:../admin');
                }else{
                    header('Location:../user');
                }
            }
        }
    }
?>