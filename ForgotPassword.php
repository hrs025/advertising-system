<?php
require_once 'connection.php';
$_SESSION['page']="";

$passwordError=0;
if(@$_REQUEST['userid']!="" && $_REQUEST['token']!="")
{
    $token=base64_encode($_REQUEST['userid'].md5($_REQUEST['token']));
    $seltoken=mysqli_query($con,"select * from registration where token='$token'");
    $seltoken1=mysqli_fetch_array($seltoken);
    if(!$seltoken1)
    {
        echo "<script>alert('Your token is expired...');window.setTimeout(function(){window.location.href='http://localhost/Grocery/sign.php';});</script>";
    }
}
else
{
    header("location:http://localhost/Grocery/sign.php");
}

if(isset($_POST['resetpassword']))
{
    $forgotpassword=md5($_POST['forgotpassword']);
    $forgotconfirmpassword=md5($_POST['forgotconfirmpassword']);
    if($forgotconfirmpassword!=$forgotpassword)
    {
        $passwordError=1;
    }
    else
    {
        if(@$_REQUEST['userid']!="" && $_REQUEST['token']!="")
        {
            $token=base64_encode($_REQUEST['userid'].md5($_REQUEST['token']));
            $seltoken=mysqli_query($con,"select * from registration where token='$token'");
            $seltoken1=mysqli_fetch_array($seltoken);
            if($seltoken1)
            {
                $uppassword=mysqli_query($con,"update registration set password='$forgotpassword',token='' where userid='$seltoken1[userid]'");
                echo "<script>alert('Your Password Successfully Updated...');window.setTimeout(function(){window.location.href='http://localhost/Grocery/sign.php';});</script>";
            } 
            else 
            {
                echo "<script>alert('Your token is expired...');window.setTimeout(function(){window.location.href='http://localhost/Grocery/sign.php';});</script>";
            }
        }
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
    
        <div class="w3-row w3-padding-24" style="width: 40%;margin:auto;">
            <p class="w3-large w3-text-black">Reset Password</p>
            <?php
            if($passwordError==1)
            {
                ?>
                <p class="w3-text-red w3-margin-left w3-small">Type Confirm Password Same As Above Password...</p>
                <?php
            }
            ?>
            <form method="post" action="">
                <table class="w3-table">
                    <tr>
                        <td><i id="showregpassword" class="fa fa-key"></i></td>
                        <td>
                            <input type="password" name="forgotpassword" id="regpassword" placeholder="New Password" required class="w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                        </td>
                    </tr>
                    <tr>
                        <td><i id="showregconpassword" class="fa fa-key"></i></td>
                        <td>
                            <input type="password" name="forgotconfirmpassword" id="regconpassword" placeholder="Confirm Password" required class="w3-input"  required="" pattern="[A-Za-z0-9 @#,]{8,20}" title="Alphabets, Digits and @#, Allowed and it shouls be above 8 characters and below 20 characters..." />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="resetpassword" class="w3-button w3-card-2 w3-medium" style="width:86%;margin-left: 14%;padding: 2.5%;"><i class="fa fa-paper-plane"></i> Reset Password</button>
                        </td>
                    </tr>
                </table>
            </form>
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