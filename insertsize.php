 <?php
require_once 'connection.php';
$_SESSION['page']="size";
require_once './adminsecurity.php';

$er=0;
$incity1=0;
if (isset($_REQUEST['sub'])) 
{
    $selsize = mysqli_query($con,"select * from size where size 
    				like '$_REQUEST[hight]'");
    $g = mysqli_fetch_array($selsize);
    if($g) 
    {
        $er = 1;
    } 
    else 
    {
        @$size = $_REQUEST['hight']." * ".$_REQUEST['width'];
        @$amount = $_REQUEST['amount'];
        $insertsize = mysqli_query($con,"insert into size values
        				(0,'$size','$amount',1)");
        header('Location:managesize.php');
        $incity1=1;
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
                                <div style="cursor: pointer;" 
                                class="w3-third w3-btn">
                                 <a style="color:#000;" href="managesize.php" >  <b>Size Information</b></a>
                                </div>
                                <div style="cursor: pointer;"  class="w3-third w3-btn ">
                                    <a style="color:#000;" href="insertsize.php"><b>Add New Size</b></a>
                                </div>
                                 
                            </div>

                            <div class="w3-row-padding w3-padding-24">
                                 <div style="width:70%;">
                                <form method="post">
                                    <table class="w3-table" style="font-size: 13px;">
                                        <tr>
                                            <td>Hoarding Size</td>
                                            <td>:</td>
                                            <td><input type="number" name="hight" placeholder="Hight" pattern="[A-Za-z ]+" title="Only Alphabet Allowed..." class="w3-input" required="" /></td> 
                                            <td><input type="number" name="width" placeholder="width" pattern="[A-Za-z ]+" title="Only Alphabet Allowed..." class="w3-input" required="" /></td>
                                        </tr>
                                        <tr>
                                            <td>Amount</td>
                                            <td>:</td>
                                             <td><input type="number" name="amount" placeholder="Amount" pattern="[A-Za-z ]+" title="Only Alphabet Allowed..." class="w3-input" required="" /></td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <button type="submit" name="sub" style="background: #f9e006" class="w3-button w3-block">Submit</button>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <?php
                                               /* if($er==1)
                                                {
                                                    echo "<font class='w3-text-red'>{$_REQUEST['size']} Already Exist...</font>";
                                                }
                                                if($incity1==1)
                                                {
                                                    echo "<font class='w3-text-green'>{@$_REQUEST['size']} Added...</font>";
                                                }*/
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
