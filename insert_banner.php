<?php
require_once 'connection.php';
 
$mediaImage = $_FILES['file']['name'];
$tmpName = $_FILES['file']['tmp_name'];
$image_type = $_FILES['file']['type'];

$cityId = $_POST['cityid'];
$area = $_POST['area'];
$size = $_POST['size'];
$package = $_POST['package'];
$userId = $_SESSION['user'];

$selectSizeAmount = "SELECT amount FROM `size` WHERE `size_id` = {$size}" ;
@$selectSizeAmount = mysqli_query($con,$selectSizeAmount);
$resultData = mysqli_fetch_array($selectSizeAmount);
$sizeAmount = $resultData['amount'];


$selectPackageAmount = "SELECT packageprice FROM `package` WHERE `packageid` = {$package}" ;
@$selectPackageAmount = mysqli_query($con,$selectPackageAmount);
$packageresultData = mysqli_fetch_array($selectPackageAmount);
$packageAmount = $packageresultData['packageprice'];
$price = $sizeAmount + $packageAmount;
 
$location = "userBanner\\";
if(move_uploaded_file($tmpName,$location.$mediaImage))
{
	$insert = "INSERT INTO `user_order` 
			(`user_order_id`, `package_id`, `size_id`, `userid`, `city_id`, `aeria_id`, 
			`banner_img`, `price`, `status`) 
			VALUES (
			NULL, '{$package}', '{$size}', '{$userId}', '{$cityId}', '{$area}', 
			'{$mediaImage}', '{$price}', '0')";
@$incity = mysqli_query($con,$insert);
}
header('Location:manage_banner.php');

