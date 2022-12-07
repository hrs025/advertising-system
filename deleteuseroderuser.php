<?php
require_once 'connection.php';
$userid = $_GET['userid'];
$deleteOder = "DELETE FROM `user_order` WHERE `user_order_id` = {$userid}" ;
@$selectSizeAmount = mysqli_query($con,$deleteOder);
header('Location:manage_pamphlet.php');

