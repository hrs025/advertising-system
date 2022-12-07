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
                        <div class="w3-rest w3-padding-24">
                          <div class="w3-row">
    <form class="form-horizontal col-sm-7" role="form" action="http://localhost/ams/insert_banner.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label class="control-label col-sm-2" for="email">City</label>
        <div class="col-sm-10">
          <select class="w3-input" name="cityid" required='' onchange="fetchData(this.value);">
            <option value='' disabled='' selected=''>--Select City--</option>
              <?php
              $city = mysqli_query($con,"select * from city where citydel=0");
              while($city1=mysqli_fetch_array($city))
              {
              ?>
              <option value="<?php echo $city1['cityid']; ?>"><?php echo $city1['cityname']; ?></option>
              <?php
              }
              ?>
          </select >
        </div>
        <br><br>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Area</label>
            <div class="col-sm-10">
              <select name="area" id="areaId" class="w3-input">  
                <option value="0">--select Area--</option>
              </select>
            </div>
      </div>
       
      <div class="form-group">
          <label class="control-label col-sm-2">Size</label>
          <div class="col-sm-10">
           <select class="w3-input" name="size" required='' >
            <option value='' disabled='' selected=''>--Select Size--</option>
              <?php
              $city = mysqli_query($con,"SELECT * FROM `size` WHERE `size_status` = 1");
              while($city1=mysqli_fetch_array($city))
              {
              ?>
              <option value="<?php echo $city1['size_id']; ?>"><?php echo $city1['size']; ?></option>
              <?php
              }
              ?>
          </select>
        </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-2">Package</label>
          <div class="col-sm-10">
            <table class="table table-striped">
              <thead>
                <tr>
                <th>Package</th>
                <th>Amount</th>
                <th>Month</th>
              </tr>
              </thead>
              <tbody>
              <?php
			  $package_size = mysqli_query($con,"SELECT * FROM `package_size`");
			  $package = mysqli_query($con,"SELECT * FROM `package`");
              while($package1=mysqli_fetch_array($package_size))
			  if($package2=mysqli_fetch_array($package))
              {
              ?>
              <tr>
                 <td> 
                      <input type="radio" name="package" 
                      value="<?php echo $package2['packageid']; ?>"><?php echo $package2['packagename']; ?>
                 </td>
                 <td><?php echo  $package1['price']; ?></td>
                 <td><?php echo  $package1['duration']; ?></td>
            </tr>
              <?php
              }
              ?>
            </tbody>
              </table>
          </div>
      </div>
      <div class="form-group">
          <label class="control-label col-sm-2">Upload Banner</label>
          <div class="col-sm-10">
            <input type="file" name="file">
          </div>
      </div>

      <div class="form-group">
          <div class="col-sm-10">
            <input type="submit" name="submit" class="btn btn-primary">
          </div>
      </div>

</form>
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
 
                           





