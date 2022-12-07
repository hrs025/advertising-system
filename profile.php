<?php
require_once 'connection.php';
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
                            <div class="w3-half">
                              <?php
                              if(isset($_POST['profile']))
                              {
                               ?>
                                <form method="post" enctype="multipart/form-data">
                                <table style="font-size:13px;" class="w3-table">
                                  <tr>
                                    <td>Name</td>
                                    <td>:</td>
                                    <td><input type="text" value="<?php echo $selUser1['username']; ?>" name="username" class="w3-input" required="" /></td>
                                  </tr>
                                  <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td><?php echo $selUser1['email']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Mobile</td>
                                    <td>:</td>
                                    <td><input type="text" value="<?php echo $selUser1['contactno']; ?>" name="contactno" class="w3-input" required="" /></td>
                                  </tr>
                                  <tr>
                                    <td>User ID</td>
                                    <td>:</td>
                                    <td><?php echo $selUser1['userid']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Registration Date</td>
                                    <td>:</td>
                                    <td><?php echo $selUser1['regdate']; ?></td>
                                  </tr>
                                  <tr>
                                    <td>Gender</td>
                                    <td>:</td>
                                    <td>
                                      <select required="" name="gender" class="w3-input">
                                        <?php
                                        if($selUser1['gender']==1)
                                        {
                                          echo "<option value='1' selected=''>Male</option>";
                                        }
                                        else
                                        {
                                          echo "<option value='1'>Male</option>";
                                        }
                                        if($selUser1['gender']==2)
                                        {
                                          echo "<option value='2' selected=''>Female</option>";
                                        }
                                        else
                                        {
                                          echo "<option value='2'>Female</option>";
                                        }
                                        if($selUser1['gender']==3)
                                        {
                                          echo "<option value='3' selected=''>Other</option>";
                                        }
                                        else
                                        {
                                          echo "<option value='3'>Other</option>";
                                        }
                                        ?>
                                      </select>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>Profile</td>
                                    <td>:</td>
                                    <td><input type="file" name="uppphoto" class="w3-input" /></td>
                                  </tr>
                                  <tr>
                                    <td colspan="3">
                                      <button type="submit" name="upprofile" style="background: #f9e006" class="w3-button w3-block">Update Profile</button>
                                    </td>
                                  </tr>
                                </table>
                              </form>
                               <?php 
                              }
                              else
                              {
                               ?>
                              <form method="post">
                              <table style="font-size:13px;" class="w3-table">
                                <tr>
                                  <td>Name</td>
                                  <td>:</td>
                                  <td><?php echo $selmprofile1['username']; ?></td>
                                </tr>
                                <tr>
                                  <td>Email</td>
                                  <td>:</td>
                                  <td><?php echo $selmprofile1['email']; ?></td>
                                </tr>
                                <tr>
                                  <td>Mobile</td>
                                  <td>:</td>
                                  <td><?php echo $selmprofile1['contactno']; ?></td>
                                </tr>
                                <tr>
                                  <td>User ID</td>
                                  <td>:</td>
                                  <td><?php echo $selmprofile1['userid']; ?></td>
                                </tr>
                                <tr>
                                  <td>Registration Date</td>
                                  <td>:</td>
                                  <td><?php echo $selmprofile1['regdate']; ?></td>
                                </tr>
                                <tr>
                                  <td>Gender</td>
                                  <td>:</td>
                                  <td>
                                    <?php
                                    if($selmprofile1['gender']==1)
                                    {
                                      echo "Male";
                                    }
                                    else if($selmprofile1['gender']==2)
                                    {
                                      echo "Female";
                                    }
                                    else
                                    {
                                      echo "Other";
                                    }
                                    ?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <button type="submit" name="profile" style="background: #f9e006" class="w3-button w3-block">Edit Profile</button>
                                  </td>
                                </tr>
                              </table>
                            </form>
                            <?php 
                              }
                              ?>
                            </div>
                            <div class="w3-half">
                              <form method="post">
                                <table class="w3-table" style="font-size:13px;" >
                                  <tr>
                                    <td><i class="fa fa-key"><i id="showregpassword" class="fa fa-eye" style="z-index:999;margin-left: 33%;position: absolute;font-size: 20px;"></i></i></td>
                                    <td>
                                        <input type="password" name="password" id="password" placeholder="Type Password Here.." required class="w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-key"></i><i id="showregconpassword" class="fa fa-eye" style="z-index:999;margin-left: 33%;position: absolute;font-size: 20px;"></i></td>
                                    <td>
                                        <input type="password" name="cpassword" id="cpassword" placeholder="Type Confirm Password Here..." required class="w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                                    </td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <button type="submit" name="uppassword" style="background: #f9e006" class="w3-button w3-block">Update Password</button>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2">
                                    <?php
                                    if($passError==1)
                                    {
                                      echo "<font class='w3-text-red'>Invalid Confirm Password</font>";
                                    }
                                    if($success==1)
                                    {
                                      echo "<font class='w3-text-green'>Password Updated</font>";
                                    }
                                    ?>
                                  </td>
                                </tr>
                                </table>
                              </form>
                            </div>
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