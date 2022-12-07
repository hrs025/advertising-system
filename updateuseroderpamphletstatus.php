<?php
require_once 'connection.php';
$userId = $_GET['userId'];


$selectStatus = "SELECT  `status` 
		FROM `user_pamphlet_order` 
		WHERE pamphletID = 	{$userId}";
$statusResult = mysqli_query($con,$selectStatus);
$status = mysqli_fetch_array($statusResult);
$updatestatus = 0;
if(!$status['status'])
{
	$updatestatus = 1;
}
$deleteOder = "UPDATE `user_pamphlet_order`
			 SET `status`={$updatestatus} 
			  WHERE `pamphletID` = {$userId}" ;
@$selectSizeAmount = mysqli_query($con,$deleteOder);
header('Location:manageuseroderpamphlet.php');

