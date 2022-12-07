<?php
require_once 'connection.php';

if(isset($_GET['cityId']))
{
    $cityid = $_GET['cityId'];
    $select = "SELECT * FROM `area` WHERE cityid = $cityid";
    $selectArea1 = mysqli_query($con,$select);
      
     $data ="<option value='0'>--select Area--</option>";
      while($city1=mysqli_fetch_array($selectArea1))
      {
         $data .= "<option value='".$city1['areaid']."'>".$city1['areaname']."</option>";
         
        }
    echo $data; 
}

?>

