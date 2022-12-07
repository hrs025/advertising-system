<?php
require_once 'connection.php';
$_SESSION['page']="city";
require_once './adminsecurity.php';

$er=0;
$incity1=0;
if (isset($_REQUEST['sub'])) 
{
    $selcity = mysqli_query($con,"select * from city where cityname like '$_REQUEST[cityname]'");
    $g = mysqli_fetch_array($selcity);
    if($g) 
    {
        $er = 1;
    } 
    else 
    {
        $incity = mysqli_query($con,"insert into city values(0,'$_REQUEST[cityname]',0)");
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
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('city','display');display('city',1,5);">
                                    <b>City Information</b>
                                </div>
                                <div style="cursor: pointer;"  class="w3-third">
                                    <a style="color:#000;" href="insertcity.php"><b>Add New City</b></a>
                                </div>
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('city','recyclebin');recyclebin('rcity',1,5);">
                                    <b>Restore City</b>
                                </div>
                            </div>

                            <div class="w3-row-padding w3-padding-24" id="misscity" >
                                <div class="w3-half">
                                <form method="post">
                                    <table class="w3-table" style="font-size: 13px;">
                                        <tr>
                                            <td>City</td>
                                            <td>:</td>
                                            <td><input type="text" name="cityname" placeholder="Type City Here..." pattern="[A-Za-z ]+" title="Only Alphabet Allowed..." class="w3-input" required="" /></td>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <button type="submit" name="sub" style="background: #f9e006" class="w3-button w3-block">Submit</button>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <?php
                                                if($er==1)
                                                {
                                                    echo "<font class='w3-text-red'>{$_REQUEST['cityname']} Already Exist...</font>";
                                                }
                                                if($incity1==1)
                                                {
                                                    echo "<font class='w3-text-green'>{$_REQUEST['cityname']} Added...</font>";
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