<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes" />
        <meta charset="UTF-8" />
        <!-- The above 3 meta tags must come first in the head -->
        <link rel="stylesheet" href="../components/header_admin/style.css">
        <link rel="stylesheet" href="./style.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js" integrity="sha512-sW/w8s4RWTdFFSduOTGtk4isV1+190E/GghVffMA9XczdJ2MDzSzLEubKAs5h0wzgSJOQTRYyaz73L3d6RtJSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	    <title>Phân tích</title>
	<style>
		table {
			margin: 24px auto;
			border-collapse: collapse;
			width: 90%;
			box-sizing: border-box;
			color: black;
			font-family: Arial, Helvetica, sans-serif;;
			font-size: 17px;
			text-align: left;
		}
		td{
			width: max-content;
			padding: 8px;
			border: 1px solid #ccc;
		}
		th {
			background-color: #588c7e;
			color: white;
			border: 1px solid #ccc;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2
		}

		button {
			margin-top: 10px;
			padding: 8px 12px;
			background-color: #8daf15;
			color: #fff;
			border: none;
		}
		button:hover{
			cursor: pointer;
			opacity: 0.7;
		}
        select, option, input{
            width: 120px;
            height: 30px;
        }
        label{
            display: inline-block;
            width: 150px;
            padding: 8px 12px;
        }
	</style>
</head>
<body>
	<?php include_once("../components/header_admin/index.php");?>
	<div style="width: 100%; display: flex; flex-direction: row; margin-top: 70px;">
		<div class="navigate__admin">
			<a href="show_product.php"><div>danh sách sản phẩm</div></a>
			<a href="addproduct.php"><div>thêm sản phẩm</div></a>
			<a href="editproduct.php"><div>cập nhật sản phẩm</div></a>
			<a href="deleteproduct.php"><div>xóa sản phẩm</div></a>
			<a href="addcolor.php"><div>thêm màu sản phẩm</div></a>
			<a href="addcompany.php"><div>thêm công ty</div></a>
			<a href="addcapacity.php"><div>thêm dung lượng</div></a>
			<a href="order.php"><div>đơn hàng</div></a>
            <a href="analysis.php"><div style="border-right: 5px solid #ffd503;">Thống kê doanh thu</div></a>
		</div>
		<div style="flex: 1;display: flex; flex-direction: row; justify-content: space-around; align-items: space-around;">
            <div><canvas id="myChart" width="800" height="500"></canvas></div>
            <div style="margin-top: 20px">
                <form method="POST" action="">
                    <label>Lọc: </label>
                    <select name="type" onchange="this.form.submit()">
                        <?php
                        if(isset($_POST["type"])){
                            if($_POST["type"] == "Ngày"){
                                echo "
                                <option value='Ngày' selected=''>Ngày</option>
                                <option value='Tháng'>Tháng</option>
                                <option value='Năm'>Năm</option>";
                            }else if($_POST["type"] == "Tháng"){
                                echo "
                                <option value='Ngày'>Ngày</option>
                                <option value='Tháng' selected=''>Tháng</option>
                                <option value='Năm'>Năm</option>";
                            }else{
                                echo "
                                <option value='Ngày'>Ngày</option>
                                <option value='Tháng'>Tháng</option>
                                <option value='Năm' selected=''>Năm</option>";
                            }
                        }else{
                            echo "
                                <option value='Ngày'>Ngày</option>
                                <option value='Tháng'>Tháng</option>
                                <option value='Năm'>Năm</option>";
                        }
                        ?>
                        
                    </select><br>
                </form>
                <form action="" method="POST">
                    <label for="bd">Ngày bắt đầu</label>
                    <input type="date" name="dateStart" id="bd"><br>
                    <label for="kt">Ngày kết thúc</label>
                    <input type="date" name="dateEnd" id="kt" onchange="this.form.submit()">
                </form>
            </div>
        </div>
	</div>
    <?php
        
    ?>
    <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                <?php
                include_once("./connect_db.php");
                if(isset($_POST['type'])){
                    if($_POST['type'] == "ngày"){
                        $query = "SELECT SUM(orderdetails.Total) as sumTotal, Date(orderdetails.DateOrder) as date from orderdetails GROUP BY Date(orderdetails.DateOrder) ";
                        $result = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "\"".$row['date']."\",";
                        }
                    }else if($_POST['type'] == "tháng"){
                        $query = "SELECT SUM(orderdetails.Total) as sumTotal, MONTH(orderdetails.DateOrder) as date from orderdetails GROUP BY MONTH(orderdetails.DateOrder) ";
                        $result = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "\"".$row['date']."\",";
                        }
                    }else{
                        $query = "SELECT SUM(orderdetails.Total) as sumTotal, YEAR(orderdetails.DateOrder) as date from orderdetails GROUP BY YEAR(orderdetails.DateOrder) ";
                        $result = mysqli_query($conn,$query);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "\"".$row['date']."\",";
                        }
                    }
                }else if(isset($_POST['dateEnd'])){
                        $start = $_POST["dateStart"];
                        $end = $_POST["dateEnd"];
                        $query = "SELECT SUM(orderdetails.Total) as sumTotal, Date(orderdetails.DateOrder) as date from orderdetails  where Date(orderdetails.DateOrder) BETWEEN '$start' AND '$end' GROUP BY Date(orderdetails.DateOrder) ";
                            $result = mysqli_query($conn,$query);
                            while($row = mysqli_fetch_assoc($result)){
                                echo "\"".$row['date']."\",";
                        }
                }else{
                    $query = "SELECT SUM(orderdetails.Total) as sumTotal, Date(orderdetails.DateOrder) as date from orderdetails GROUP BY Date(orderdetails.DateOrder) ";
                    $result = mysqli_query($conn,$query);
                    while($row = mysqli_fetch_assoc($result)){
                        echo "\"".$row['date']."\",";
                    }
                }
                
                ?>
            ],
            datasets: [{
                label: <?php 
                if($_SERVER["REQUEST_METHOD"] == "POST")
                    if(isset($_POST['type'])){
                        echo "\"".$_POST['type']."\"";
                    }else{
                        echo "\"".$_POST['dateStart']." -> ".$_POST['dateEnd']."\"";
                    }
                else
                    echo "\"Thống kê ngày\"";?>,
                data: [
                    <?php
                    $result = mysqli_query($conn,$query);
                    while($row2 = mysqli_fetch_assoc($result)){
                        echo "".$row2['sumTotal'].",";
                    }
                    ?>
                ],
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ],
                borderWidth: 1,
            }]
        }
    });
    </script>
</body>
</html>