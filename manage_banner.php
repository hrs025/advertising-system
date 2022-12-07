<?php
require_once 'connection.php';
require_once 'fetchdata.php';
$_SESSION['page']="profile";
 
if($_SESSION['user']=="")
{
  header("location:sign.php");
}

$passError = 0;
$success=0;
if(isset($_POST['uppassword']))
{
  $password = md5($_POST['password']);
  $cpassword = md5($_POST['cpassword']);

  if($cpassword != $password)
  {
    $passError=1;
  }
  else
  {
    $uppassword = mysqli_query($con,"update registration set password='$password' where userid='$_SESSION[user]'");
    if($uppassword)
    {
      $success=1;
    }  
  }
}

if(isset($_POST['profile']))
{
  $selUser = mysqli_query($con,"select * from registration where userid='$_SESSION[user]'");
  $selUser1=mysqli_fetch_array($selUser);
}

$er1=0;
$er2=0;
if(isset($_POST['upprofile']))
{
    if(strlen($_FILES['uppphoto']['name'])>0)
     {
        $sel=  mysqli_query($con,"select *from registration where userid like '$_SESSION[user]'");
        $sel1=  mysqli_fetch_array($sel);
        if(file_exists($sel1['profile']))
        {
         unlink(@$sel1['profile']);
        }
        $fname=$_FILES['uppphoto']['name'];
        $type=$_FILES['uppphoto']['type'];
        $ex=".".substr($type, 6);
         if($ex==".png" || $ex==".jpg" || $ex==".jpeg")
         {
             $size=$_FILES['uppphoto']['size']/1024;
             $size=$size/1024;
             if($size<=3)
             {
                 $name=$_SESSION['user'].$ex;
                 $path1="profile/".$name;
                 $path2= dirname(__FILE__)."/".$path1;
             }
             else 
             {
                 $er2=1;
             }
         }
         else
         {
             $er1=1;
         }
     }
     else
     {
        $selphoto=  mysqli_query($con,"select * from registration where userid like '$_SESSION[user]'");
        $selphoto1=  mysqli_fetch_array($selphoto);
        $path1=$selphoto1['profile'];
        $path2= dirname(__FILE__)."/".$path1;
     }

     if($er1!=1 && $er2!=1)
     {
        move_uploaded_file($_FILES['uppphoto']['tmp_name'], $path2);
        $uppro=  mysqli_query($con,"update registration set  username='$_POST[username]',contactno='$_POST[contactno]',gender=$_POST[gender],profile='$path1' where userid like '$_SESSION[user]'");
        header("location:profile.php");
     }
}

$selmprofile=  mysqli_query($con,"select * from registration where userid like '$_SESSION[user]'");
$selmprofile1=  mysqli_fetch_array($selmprofile);
$total =0;
?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="">

        <div id="header-wrapper">

            <?php
            require_once 'toppatti.php';
            require_once 'logomenu.php';
            ?>

        </div>

        <section>
            <div class="w3-row-padding">
                <div class="w3-row w3-padding-16">
                    <div class="w3-row">
                        <?php
                        require_once './welcome.php';
                        ?>
                    </div>

                    <div class="w3-row">
                        <div class="w3-quarter">
                            <?php
                            if($_SESSION['type']==0)
                            {
                              require_once 'admin_navigation.php';
                            }
                            else if($_SESSION['type']==1)
                            {
                              require_once 'serviceprovider_navigation.php';
                            }
                            else
                            {
                              require_once 'member_navigation.php'; 
                            }
                            ?>
                        </div>
                            <a href="add_banner.php"><button class="btn w3-blue">Add Hoarding</button></a>

                        <div class="w3-rest w3-padding-24">

                          <div class="w3-row">
      <table class="table table-hover">
                                <thead>
                                    <tr class="w3-blue">
  
                                        <th>Hoarding Image</th>
                                        <th>Pachage</th>
                                        <th>City</th>
                                        <th>Area</th>
                                        <th>Hoarding Size</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <?php 
                                $selorder = "SELECT u.`user_order_id`,p.packagename,r.username,s.size,c.cityname,a.areaname,u.`banner_img`,u.`price`,u.`status` FROM `user_order` u 
JOIN registration r on u.userid = r.userid
JOIN package p on p.packageid = u.`package_id`
JOIN size s on s.size_id = u.`size_id`
JOIN city  c on c.cityid = u.`city_Id`
JOIN area a on a.areaid = u.`aeria_Id` 
WHERE u.`userid` = '$_SESSION[user]'";
                    $selorderResult = mysqli_query($con,$selorder)
                    or die("Error: ".mysqli_error($con));
					
                           while ($order = mysqli_fetch_array($selorderResult))
                           {  
                            $total += $order['price'];
                            ?>
                            <tr>
 
                                <td width="10%" height="10%"><img src="userBanner/<?php echo $order['banner_img'];?>" /></td>
                                <td><?php echo $order['packagename'];?></td>
                                <td><?php echo $order['cityname'];?></td>
                                <td><?php echo $order['areaname'];?></td>
                                <td><?php echo $order['size'];?></td>
                                <td><?php echo $order['price'];?></td>
                                <td><?php echo $order['status']? "<font style='color:green'><b>Active</b></font>" : "In-Active";?></td>
                                <td><a href="deleteuseroderuser.php?userId=<?php echo $order['userid']; ?>"><button type="button" class="btn btn-warning">Delete</button></a></td>
                               
                            </tr>
                           <?php } ?>
                            </table>
</div>
</div>
</div>
</div>

</div>
</section>
<?php
require_once 'socialicon.php';
?>
<?php
require_once 'footer.php';
?>
</body>
</html>
 
                           





