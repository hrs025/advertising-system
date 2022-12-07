<?php
require_once 'connection.php';
$_SESSION['page']="";
require_once './serviceprovidersecurity.php';
if(@$_REQUEST['delid']!="")
{
    $del=  mysqli_query($con,"delete from contactserviceprovider where contactid=$_REQUEST[delid]");
    header("location:contactuser.php");
}

?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    
      
     
    ?>

    <body onload="missuserbill('missuserbill','badha');">

        <div id="header-wrapper">

            <?php
            require_once 'toppatti.php';
            require_once 'logomenu.php';
            ?>

        </div>


        <section style="background: rgba(0,0,0,0.01);">
            <div class="container-fluid">
                <div class="row adminmain">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="margin: 0;padding: 0;">
                            <?php
                                        require_once './serviceprovidertoppatti.php';
                            ?>
                            <div class="col-md-12 col-sm-12 col-xs-12 adminsite">
                                &nbsp;&nbsp;&nbsp;&nbsp;<font> <a href="serviceproviderpanel.php"><i class="fa fa-home"></i>&nbsp;Home</a></font>&nbsp;>&nbsp;<a href="contactuser.php">My Business Contact</a> </font>
                            </div>
                        </div>
                    </div>
                </div>
                    
                    
                    
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <p style="text-align: center;font-size: 20px;background: #01c38e;padding: 10px;color:#fff;">My Business Contact</p>
                    </div>
                </div>
                    
                <form action="" method="post" name="contactdetail">
                <div class="row" style="padding-top: 3%;">
                    <div class="col-md-10 col-md-offset-1">

                        <?php
                        $sel=  mysqli_query($con,"select *from servicesassign where userid like '$_SESSION[user]'");
                        while($sel1=  mysqli_fetch_array($sel))
                        {
                            ?>
                        <fieldset><legend style="text-transform: capitalize;"><?php echo $sel1[3]; ?></legend></fieldset>
                        <div class="row" style="padding-top: 3%;">
                            <div class="col-md-8 col-md-offset-2">
                                <table class="table table-responsive table-bordered mis">
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Delete</th>
                                    </tr>
                                    
                            <?php
                            $c=0;
                                $cu=  mysqli_query($con,"select *from contactserviceprovider where assignid=$sel1[0]");
                                while($cuu=  mysqli_fetch_array($cu))
                                {
                                    $c++;
                                 ?>   
                        
                                                                        
                                    <tr>
                                        <td class="f"><?php echo $c; ?></td>
                                        <td><?php echo $cuu[2]; ?></td>
                                        <td><?php echo $cuu[3]; ?></td>
                                        <td><?php echo $cuu[4]; ?></td>
                                        <td><font><a href="contactuser.php?delid=<?php echo $cuu[0]; ?>"<i class="fa fa-close"></i></font></td>
                                    </tr>
                                <?php    
                                }
                                ?>
                                    <tr>
                                        <td colspan="5" class="f">
                                            Total Contacts In <font style="text-transform: capitalize;"><?php echo $sel1[3]; ?></font> Are : <?php echo $c; ?>
                                        </td>
                                    </tr>     
                                </table>
                            </div>
                            
                        </div>
                        <?php
                        }
                       
                        ?>
                    </div>
                </div>
                </form>
                    
               
             
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