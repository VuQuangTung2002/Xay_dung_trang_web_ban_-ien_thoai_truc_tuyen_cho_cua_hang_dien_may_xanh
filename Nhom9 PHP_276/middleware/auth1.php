<?php
    require_once("../connect_db.php");
    session_start();
    if(isset($_SESSION["userId"]) || isset($_SESSION["username"])){
        $sess_userId = $_SESSION["userId"];
        $sess_username = $_SESSION["username"];
        $query = "select * from user where UserID = '$sess_userId' and UserName = '$sess_username'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
            $data = mysqli_fetch_assoc($result);
        }
        if($_SESSION["userId"] == $data["UserID"] || $_SESSION["username"] == $data["UserName"]){
            
            if($_SESSION["role"] == "1"){
                header('Location: ../user');
            }else{
                header('Location: ../admin');
            }
        }
    }
?>