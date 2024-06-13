<?php
if(isset($_POST['show'])){

    header('Location: show_product.php');
    }
   else
   {
include 'connect_db.php';

$ProductName=$_POST['productname'];
$Price =$_POST['productprice'];
$ProductNote =$_POST['note'];
$ProductID =$_POST['productid'];

$sql = "UPDATE product SET 
                    ProductName='$ProductName',
                    Price ='$Price',
                    ProductNote ='$ProductNote'
                 WHERE ProductID ='$ProductID' ";



if (mysqli_query($conn, $sql)) {
echo '<br>'. "Record updated successfully";
} else {
echo "Error updating record: " . mysqli_error($conn);
}
    header('Location:editproduct.php');
}

?>