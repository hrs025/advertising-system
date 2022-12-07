<?php
require_once 'connection.php';
$userId = $_GET['userId'];






$selectStatus = "SELECT  `status` FROM `user_order` WHERE user_order_id = {$userId}";
$statusResult = mysqli_query($con,$selectStatus);
$status = mysqli_fetch_array($statusResult);
$updatestatus = 0;
if(!$status['status'])
{
	$updatestatus = 1;
}
$deleteOder = "UPDATE `user_order` SET `status`={$updatestatus}  WHERE `user_order_id` = {$userId}" ;
@$selectSizeAmount = mysqli_query($con,$deleteOder);
header('Location:manageuseroder.php');

