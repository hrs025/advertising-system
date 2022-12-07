<?php
require_once 'connection.php';
 
$mediaImage = $_FILES['file']['name'];
$tmpName = $_FILES['file']['tmp_name'];
$image_type = $_FILES['file']['type'];

$cityId = $_POST['cityid'];
$area = $_POST['area'];
$pamphlet = $_POST['pamphlet'];
$userId = $_SESSION['user'];

$price = 2.5 * $pamphlet;

	 
$location = "userPamphlet\\";
if(move_uploaded_file($tmpName,$location.$mediaImage))
{
	$insert = "INSERT INTO  `user_pamphlet_order` 
			 (`pamphletID`, `userid`, `city_Id`, `aeria_Id`, `no_of_pamphlet`, `price`,`pamphletImg`)  
	VALUES (NULL, '{$userId}','{$cityId}', '{$area}', '{$pamphlet}', '{$price}',
		'{$mediaImage}')";
@$incity = mysqli_query($con,$insert);
}
header('Location:manage_pamphlet.php');

