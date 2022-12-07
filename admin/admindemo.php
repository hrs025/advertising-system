<?php
require_once 'connection.php';
$_SESSION['page']="";
require_once './adminsecurity.php';

if(isset($_REQUEST['upprofile']))
{
    if(strlen($_FILES['uppphoto']['name'])>0)
     {
        $sel=  mysqli_query($con,"select *from registration where userid like '$_SESSION[user]'");
        $sel1=  mysqli_fetch_array($sel);
         unlink($sel1[8]);
        $fname=$_FILES['uppphoto']['name'];
        $type=$_FILES['uppphoto']['type'];
        $ex=".".substr($type, 6);
         if($ex==".png" || $ex==".jpg" || $ex==".jpeg")
         {
             $size=$_FILES['uppphoto']['size']/1024;
             $size=$size/1024;
             if($size<=5)
             {
                 $name=$_REQUEST['photoupid'].$ex;
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
            $path1=$selphoto1[8];
            $path2= dirname(__FILE__)."/".$path1;
     }
     if($er1!=1 && $er2!=1)
     {
        
         $uppro=  mysqli_query($con,"update registration set  profile='$path1' where userid like '$_REQUEST[photoupid]'");
         header("location:adminprofile.php");
           $selmprofile=  mysqli_query($con,"select * from registration where userid like '$_SESSION[user]'");
           $selmprofile1=  mysqli_fetch_array($selmprofile);
        move_uploaded_file($_FILES['uppphoto']['tmp_name'], $path2);
           
     }
}
if(isset($_REQUEST['upprofilecon']))
{
    $uppro=  mysqli_query($con,"update registration set username='$_REQUEST[upuname]',email='$_REQUEST[upemail]',contactno='$_REQUEST[upmobile]',password='$_REQUEST[uppass]' where userid like '$_REQUEST[upid]'");
    header("location:adminprofile.php");
   
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
                            require_once 'admin/admin_navigation.php';
                            ?>
                        </div>
                        <div class="w3-rest">
                            Dashboard
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