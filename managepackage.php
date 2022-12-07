<?php
require_once 'connection.php';
$_SESSION['page']="package";
require_once './adminsecurity.php';
?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="miss('package','display');">  

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
                                City
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