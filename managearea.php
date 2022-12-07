<?php
require_once 'connection.php';
$_SESSION['page']="area";
require_once './adminsecurity.php';
?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="miss('area','display');">  

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
                                Area
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