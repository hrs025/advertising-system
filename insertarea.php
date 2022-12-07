<?php
require_once 'connection.php';
$_SESSION['page']="area";
require_once './adminsecurity.php';

$er=0;
$success=0;
if (isset($_REQUEST['sub'])) 
{
    $cityid = $_POST['cityid'];
    $areaname = $_POST['areaname'];
    $selarea = mysqli_query($con,"select * from area where cityid=$cityid and areaname='$areaname'");
    $selarea1 = mysqli_fetch_array($selarea);
    if($selarea1) 
    {
        $er = 1;
    } 
    else 
    {
        $addarea = mysqli_query($con,"insert into area values(0,$cityid,'$areaname',0)");
        $success=1;
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
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('area','display');display('area',1,5);">
                                    <b>Area Information</b>
                                </div>
                                <div style="cursor: pointer;"  class="w3-third">
                                    <a style="color:#000;" href="insertarea.php"><b>Add New Area</b></a>
                                </div>
                                <div style="cursor: pointer;" class="w3-third" onclick="miss('area','recyclebin');recyclebin('rare',1,5);">
                                    <b>Restore Area</b>
                                </div>
                            </div>

                            <div class="w3-row-padding w3-padding-24" id="missarea" >
                                <div class="w3-half">
                                    <form method="post">
                                        <table class="w3-table" style="font-size: 13px;">
                                            <tr>
                                                <td>City</td>
                                                <td>:</td>
                                                <td>
                                                    <select class="w3-input" name="cityid" required=''>
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
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Area</td>
                                                <td>:</td>
                                                <td><input type="text" name="areaname" placeholder="Type Area Here..." pattern="[A-Za-z ]+" title="Only Alphabet Allowed..." class="w3-input" required="" /></td>
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
                                                        echo "<font class='w3-text-red'>{$_POST['areaname']} Already Exist In Selected City...</font>";
                                                    }
                                                    if($success==1)
                                                    {
                                                        echo "<font class='w3-text-green'>{$_POST['areaname']} Added...</font>";
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