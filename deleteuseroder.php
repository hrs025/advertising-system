<?php
require_once 'connection.php';
$userId = $_GET['userId'];
$deleteOder = "DELETE FROM `user_order` WHERE `user_order_id` = {$userId}" ;
@$selectSizeAmount = mysqli_query($con,$deleteOder);
header('Location:manageuseroder.php');

