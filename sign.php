<?php
require_once 'connection.php';
$_SESSION['page']="";

if(@$_SESSION['user']!="")
{
    if($_SESSION['type']==0)
    {
        header("location:adminpanel.php");
    }
    else
    {
        header("location:memberpanel.php");
    }
}

//Registration Verification
if(@$_REQUEST['userid']!="" &&  @$_REQUEST['token']!="")
{
    $token=base64_encode($_REQUEST['userid'].$_REQUEST['token']);
    $seltoken=mysqli_query($con,"select userid from registration where token='$token'");
    $seltoken1=mysqli_fetch_array($seltoken);
    if($seltoken1)
    {
        $upstatus=mysqli_query($con,"update registration set status=1,token='' where userid=$seltoken1[0]");
        echo "<script>alert('Your email is successfully verified.');window.setTimeout(function(){window.location.href='http://localhost/ams/sign.php';});</script>";
    } else 
    {
        echo "<script>alert('Your token is expired...');window.setTimeout(function(){window.location.href='http://localhost/ams/sign.php';});</script>";
    }
}


// Add User
date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d");
$time = date("H:i:s");
$emailError=0;
$userIdError=0;
$passwordError=0;
$extensionError=0;
$sizeError=0;
$sendEmail=0;
$userStatus=0;

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $userid = $_POST['userid'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $regdate = $date;
    $block = 1;
    $usertype = 2;
    $gender = $_POST['gender'];
    $status = 1;

    $selEmail=mysqli_query($con,"select *from registration where email='$email'");
    $selEmail1=mysqli_fetch_array($selEmail);
    if($selEmail1[0]!="")
    {
        $emailError=1;
    }
    $selUserId=mysqli_query($con,"select *from registration where userid='$userid'");
    $selUserId1=mysqli_fetch_array($selUserId);
    if($selUserId1[0]!="")
    {
        $userIdError=1;
    }
    if($cpassword!=$password)
    {
        $passwordError=1;
    }

    if($emailError != 1 && $userIdError !=1 && $passwordError!=1)
    {
        $profile = $_FILES['profile']['name'];
        $type=$_FILES['profile']['type'];
        $ex=".".substr($type, 6);
        if($ex==".png" || $ex==".jpg" || $ex==".jpeg" || $ex==".JPG" || $ex==".PNG" || $ex==".JPEG")
         {
             $size=$_FILES['profile']['size']/1024;
             $size=round($size/1024);
             if($size<=1)
             {
                 $name=$userid.$ex;
                 $path1="profile/".$name;
                 $path2= dirname(__FILE__)."/".$path1;
             }
             else 
             {
                 $sizeError=1;
             }
         }
         else
         {
             $extensionError=1;
         }


         if($extensionError!=1 && $sizeError!=1)
         {
            move_uploaded_file($_FILES['profile']['tmp_name'], $path2);
            $token = base64_encode($userid.$password);
            $addUser = mysqli_query($con,"insert into registration values('$username','$email','$contactno','$userid','$password','$regdate',$block,$usertype,'$path1',$gender,'',$status)");
            $addLoginInfo = mysqli_query($con,"insert into logintime values('$userid','$date','$time')");

            if($addUser && $addLoginInfo)
            {
                $userStatus = 1;
                $to=$email;
                $subject="Registration";
                $body="<a href='http://localhost/ams/sign.php?userid=$userid&token=$password'>Click here to verify your account</a>
                <br/>
                ";
                $mailstatus=send_mail($to,$subject,$body);
                $sendEmail = 1;
                $_POST = []; 
                 
            }

         }
            
    }

}

//Login
$blockStatus=0;
$statusError=0;
$userError=0;

if(isset($_POST['login']))
{
    $userid = $_POST['userid'];
    $password = md5($_POST['password']);

    $selloguser=mysqli_query($con,"select * from registration where userid='$userid' and password='$password'");
    $selloguser1=mysqli_fetch_array($selloguser);
    if($selloguser1)
    {
        if($selloguser1['status']==1)
        {
            if($selloguser1['block']==1)
            {
                $_SESSION['user']=$selloguser1['userid'];
                $_SESSION['type']=$selloguser1['type'];
                $_SESSION['date']=$date;
                $_SESSION['time']=$time;

                if(isset($_POST['rememberme']))
                {
                    setcookie("cuserid",$_SESSION['user']);
                    setcookie("cpassword",$_POST['password']);
                }
                if($_SESSION['type']==0)
                {
                    header("location:adminpanel.php");
                }
                else
                {
                    header("location:index.php");
                }
            }
            else
            {
                $blockStatus=1;
            }
        }
        else
        {
            $statusError=1;
        }
    }
    else
    {
        $userError=1;
    }
}

//Forgot or reset Password
$emailForgotError=0;
$emailStatus=0;
if(isset($_POST['sendpassword']))
{
    $forgotEmail=$_POST['forgotemail'];
    $seluser=mysqli_query($con,"select * from registration where email='$forgotEmail'");
    $seluser1=mysqli_fetch_array($seluser);
    if($seluser1)
    {
        $userid=$seluser1['userid'];
        $password=md5($seluser1['password']);
        $token = base64_encode($userid.$password);
        $upuser=mysqli_query($con,"update registration set token='$token' where userid='$userid'");
        $to=$seluser1['email'];
        $subject="Forgot Password";
        $body="<a href='http://localhost/ams/ForgotPassword.php?userid=$userid&token=$password'>Click here to reset password</a>";
        $mailstatus=send_mail($to,$subject,$body);
        
            $emailStatus=1;
        
    }
    else
    {
        $emailForgotError=1;
    }
}

?>

<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>
   

    <body>  
        <div id="header-wrapper">
            <?php
            require_once 'toppatti.php';
            require_once 'logomenu.php';
            ?>
        </div>
    

        <div class="w3-row-padding contact w3-white" style="">
    <br/>
    <br/>
    <div class="w3-row-padding">
        <div class="w3-half w3-mobile" style="width:50%;padding-left:2.5%;padding-right:7%;border-right: 2px solid #eee;">
            <span class="w3-large w3-text-black">Sign Up</span><span style="margin-left: 8%;" class="w3-text-green w3-small">
            <?php
            if($sendEmail==1)
            {
                ?>
                Please Verify Your Account...
                <?php
            }
            ?>
            </span>
            <form method="post" class="w3-padding-24" enctype="multipart/form-data">
                <table style="font-size: 13px;" class="Icon w3-table w3-text-black">
                    <tr>
                        <td><i class="fa fa-user"></i></td>
                        <td>
                            <input type="text" name="username" placeholder="Type Full Name Here..." required class=" Box w3-input" value="<?php echo @$_POST['username']; ?>" required="" pattern="[A-Za-z ]+" title="Only Alphabet And Space Allowed..." />
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-envelope"></i></td>
                        <td>
                            <input type="email" name="email" value="<?php echo @$_POST['email']; ?>" placeholder="Type Email Here..." required class="Box w3-input"  required="" />
                        </td>
                    </tr>
                    
                    <?php
                    if($emailError==1)
                    {
                        ?>
                        <tr>
                            <td colspan="2"><font class="w3-text-red w3-margin-left w3-small">Email ID Already Exist...</font>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                        
                    <tr>
                        <td><i class="fa fa-phone"></i></td>
                        <td>
                            <input type="text" name="contactno" value="<?php echo @$_POST['contactno']; ?>" placeholder="8758441385" required class="Box w3-input" required="" pattern="[0-9]{10}" title="Only 10 Digits Allowed..."/>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-user"></i></td>
                        <td>
                            <input type="text" name="userid" placeholder="Type User ID Here..." required class="Box w3-input" value="<?php echo @$_POST['userid']; ?>" required="" title="Only Alphabet And Space Allowed..." />
                        </td>
                    </tr>
                    
                    <?php
                    if($userIdError==1)
                    {
                        ?>
                        <tr>
                            <td colspan="2">
                                <font class="w3-text-red w3-margin-left w3-small">User ID Already Exist...</font>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                        
                    <tr>
                        <td><i class="fa fa-key"></i><i id="showregpassword" class="fa fa-eye" style="z-index:999;margin-left: 33%;margin-top:7px;position: absolute;font-size: 20px;"></i></td>
                        <td>
                            <input type="password" name="password" value="<?php echo @$_POST['password']; ?>" id="password" placeholder="Type Password Here.." required class="Box w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-key"></i><i id="showregconpassword" class="fa fa-eye" style="z-index:999;margin-left: 33%;margin-top:7px;position: absolute;font-size: 20px;"></i></td>
                        <td>
                            <input type="password" name="cpassword" id="cpassword" value="<?php echo @$_POST['cpassword']; ?>" placeholder="Type Confirm Password Here..." required class="Box w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                        </td>
                    </tr>
                    
                    <?php
                    if($passwordError==1)
                    {
                        ?>
                        <tr>
                            <td colspan="2">
                                <font class="w3-text-red w3-margin-left w3-small">Type Confirm Password Same As Above Password...</font>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                        
                    <tr>
                        <td><i class="fa fa-users"></i></td>
                        <td>
                            <select name="gender" class="Box w3-input" required="">
                                <option disabled="" selected="" value="">--Select Gender--</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-camera"></i></td>
                        <td>
                            <input type="file" name="profile" value="<?php echo @$_POST['profile']; ?>" required class="Box w3-input" required="" />
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if($extensionError==1)
                            {
                                ?>
                                <font class="w3-text-red w3-margin-left w3-small">Only Allow .png, .jpg, .jpeg Format...</font>
                                <?php
                            }
                            else if($sizeError==1)
                            {
                                ?>
                                <font class="w3-text-red w3-margin-left w3-small">Size Must Be Less Than 3MB...</font>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit"  name="submit" class="w3-button w3-card-2" style="width:46%;margin-left: 6.5%;padding: 2%;"><i class="fa fa-paper-plane"></i> Submit</button>
                            <button type="reset" class="w3-button w3-card-2" style="width:46%;padding: 2%;"><i class="fa fa-times"></i> Reset</button>
                        </td>
                    </tr>
                </table>
        </form>
        </div>

        <div class="w3-half w3-mobile w3-text-black contactinfo" style="width:50%;padding-left:5%;padding-right: 5%;">
            <span class="w3-large w3-text-black">Login</span><span style="margin-left: 8%;" class="w3-text-red w3-small">
            <?php
            if(@$userError==1)
            {
                ?>
                Invalid User...
                <?php
            }
            if(@$statusError==1)
            {
                ?>
                Please Verify Your Account
                <?php
            }
            if(@$blockStatus==1)
            {
                ?>
                You Are Blocked...
                <?php
            }
            ?>
            </span>
            <form method="post" class="w3-padding-24">
                <table style="font-size: 13px;" class="Icon w3-table w3-text-black">
                    <tr>
                        <td><i class="fa fa-user"></i></td>
                        <td>
                            <input type="text" name="userid" value="<?php echo @$_COOKIE['cuserid'];?>" placeholder="User ID" required class="Box w3-input"  required="" />
                        </td>
                    </tr>
                    <tr>
                        <td><i class="fa fa-key"></i><i id="showlogpassword" class="fa fa-eye" style="z-index:999;margin-left: 33%;margin-top:7px;position: absolute;font-size: 20px;"></i></td>
                        <td>
                            <input type="password" name="password" value="<?php echo @$_COOKIE['cpassword']; ?>" id="logpassword" placeholder="********" required class="Box w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php
                            if(@$_COOKIE['cuserid']=="")
                            {
                                ?>
                                <input type="checkbox" style="margin-left: 6%;" name="rememberme"/>                                <?php
                            }
                            else
                            {
                                ?>
                                <input type="checkbox" style="margin-left: 6%;" checked="" name="rememberme"/>
                                <?php
                            }
                            ?>
                            <font class="w3-medium"> Remember Me</font>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="login" class="w3-button w3-card-2 w3-medium" style="width:94%;margin-left: 6%;padding: 2%;"><i class="fa fa-paper-plane"></i> Login</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><p class="w3-text-black w3-small" title="Plz enter registered email in below box" style="cursor:pointer;margin-left: 6%;" id="forgot">Forgot Password?</p></td>
                    </tr>
                </table>
            </form>

                <div class="w3-row w3-section">
                    <?php
                    if(@$emailForgotError==1)
                    {
                        ?>
                        <p class="w3-text-red w3-margin-left w3-small">Please enter only registered email...</p>
                        <?php
                    }
                    ?>
                    <?php
                    if(@$emailStatus==1)
                    {
                        ?>
                        <p class="w3-text-red w3-margin-left w3-small">Sent password reset link on your email...</p>
                        <?php
                    }
                    ?>
                </div>

            <form method="post"> 
            <table style="font-size: 13px;" class="Icon w3-table w3-text-black">
                <tr>
                    <td><i class="fa fa-envelope"></i></td>
                    <td>
                        <input type="email" name="forgotemail" placeholder="Your email.." required class="Box w3-input"  required="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" name="sendpassword" class="w3-button w3-card-2 w3-block" style="width:94%;margin-left: 6%;padding: 2%;"><i class="fa fa-paper-plane"></i> Send Password</button>
                    </td>
                </tr>
            </table>   
            </form>
            
        </div>
    </div>
</div>




        <?php
        require_once 'socialicon.php';
        ?>

        <?php
        require_once 'footer.php';
        ?>


        <script type="text/javascript">
        $(document).ready(function(){
        p=0;
        $("#eye").click(function(){
            if(p==0)
            {
                $("#pass").attr("type","text");
                $(".icon").html('<i class="fa fa-eye" style="cursor:pointer" title="Hide Password"></i>');
                p=1;
            }
            else
            {
                  $("#pass").attr("type","password");
                  $(".icon").html('<i class="fa fa-eye-slash" style="cursor:pointer" title="Show Password"></i>');
                  p=0;
            }
            });
        
        $("#eye1").click(function(){
            if(p==0)
            {
                $("#password").attr("type","text");
                $(".icon1").html('<i class="fa fa-eye" style="cursor:pointer" title="Hide Password"></i>');
                p=1;
            }
            else
            {
                  $("#password").attr("type","password");
                  $(".icon1").html('<i class="fa fa-eye-slash" style="cursor:pointer" title="Show Password"></i>');
                  p=0;
            }
            });
            
            $("#eye2").click(function(){
            if(p==0)
            {
                $("#cpassword").attr("type","text");
                $(".icon2").html('<i class="fa fa-eye" style="cursor:pointer" title="Hide Password"></i>');
                p=1;
            }
            else
            {
                  $("#cpassword").attr("type","password");
                  $(".icon2").html('<i class="fa fa-eye-slash" style="cursor:pointer" title="Show Password"></i>');
                  p=0;
            }
            });
        });
        </script>
        
    </body>

</html>