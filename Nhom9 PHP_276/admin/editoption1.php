<?php
if(isset($_POST['show'])){

    header('Location: show_product.php');
    }
   else
   {
include 'connect_db.php';

$ProductDetailID =$_POST['productdetailid'];
$ColorID =$_POST['productcolor'];
$CapacityID =$_POST['productcapacity'];
$ProductScreen =$_POST['productscreen'];
$ProductOS=$_POST['productos'];
$ProductCam=$_POST['productcam'];
$ProductChip=$_POST['productchip'];
$ProductPin=$_POST['productpin'];
$CompanyID=$_POST['productcompany'];

$sql = "UPDATE productdetail SET 
                    ColorID ='$ColorID',
                    CapacityID ='$CapacityID' ,
                    ProductScreen ='$ProductScreen',
                    ProductOS='$ProductOS',
                    ProductCam='$ProductCam',
                    ProductChip='$ProductChip',
                    ProductPin='$ProductPin',
                    CompanyID='$CompanyID'
                 WHERE ProductDetailID ='$ProductDetailID' ";

if (mysqli_query($conn, $sql)) {
echo '<br>'. "Record updated successfully";
} else {
echo "Error updating record: " . mysqli_error($conn);
}
    header('Location:show_option.php');
}

?>