<?php
require_once 'connection.php';
$_SESSION['page']="package";
require_once './adminsecurity.php';

$er=0;
$inpackage1 = 0;
if (isset($_REQUEST['sub'])) 
{
    $selpackage = mysqli_query($con,"select * from package where packagename like '$_REQUEST[packagename]' and packageduration like '$_REQUEST[packageduration]') or (packagename like '$_REQUEST[packagename]' and packageduration like '$_REQUEST[packageduration]' and packageprice like '$_REQUEST[packageprice]' ");
    $g = mysqli_fetch_array($selpackage);
    if (!$g)
    {
        $inpackage= mysqli_query($con,"insert into package values(0,'$_REQUEST[packagename]','$_REQUEST[packageduration]','$_REQUEST[packageprice]',0,$_REQUEST[packageduration])");
        $inpackage1=1;
    } 
    else 
    {
        $er = 1;
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
                            require_once 'admin_navigation.php';
                            ?>
                        </div>
                        <div class="w3-rest">
                            <div class="w3-row w3-padding-16">
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('package','display');display('package',1,5);">
                                    <b>Package Information</b>
                                </div>
                                <div style="cursor: pointer;"  class="w3-third">
                                    <a style="color:#000;" href="insertpackage.php"><b>Add New Pakckage</b></a>
                                </div>
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('package','recyclebin');recyclebin('rpackage',1,5);">
                                    <b>Restore Package</b>
                                </div>
                            </div>

                            <div class="w3-row-padding w3-padding-24" id="misspackage" >
                                <div class="w3-half">
                                <form method="post">
                                    <table class="w3-table" style="font-size: 13px;">
                                        <tr>
                                            <td>Package</td>
                                            <td>:</td>
                                            <td><input class="w3-input" type="text" name="packagename" placeholder="Package Name" pattern="^[a-z ]+$" title="Only Alphabet Allowed..." required=""/></td>
                                        </tr>
                                        <tr>
                                            <td>Duration</td>
                                            <td>:</td>
                                            <td><input class="w3-input"  type="number" name="packageduration" placeholder="Package Duration(Month)" min="1" max="24"  class="form-control" required=""/></td>
                                        </tr>
                                        <tr>
                                            <td>Price</td>
                                            <td>:</td>
                                            <td><input class="w3-input" type="text" name="packageprice" placeholder="Price" pattern="^[0-9]{4}$" class="form-control" title="Price should be between 1 and 4 digit" required=""/></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <button type="submit" name="sub" style="background: #f9e006" class="w3-button w3-block">Add Package</button>
                                             </td>
                                        <tr>
                                            <td colspan="3">
                                                <?php
                                                if($er==1)
                                                {
                                                    echo "<font class='w3-text-red'>{$_REQUEST['packagename']} Already Exist...</font>";
                                                }
                                                if($inpackage1==1)
                                                {
                                                    echo "<font class='w3-text-green'>{$_REQUEST['packagename']} Added...</font>";
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