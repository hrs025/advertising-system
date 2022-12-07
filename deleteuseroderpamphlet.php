<?php
require_once 'connection.php';
$userid = $_GET['userid'];
$deleteOder = "DELETE FROM `user_pamphlet_order` WHERE `pamphletID` = {$userid}" ;
@$selectSizeAmount = mysqli_query($con,$deleteOder);
header('Location:manageuseroderpamphlet.php');

