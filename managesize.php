<?php
require_once 'connection.php';
$_SESSION['page']="size";
require_once './adminsecurity.php';
?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

       <body onload="miss('size','display');">  

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
                                <div style="cursor: pointer;" class="w3-third   w3-btn"
                                onclick="miss('size','display');display('size',1,5);">
                                    <b>Size Information</b>
                                </div>
                                <div style="cursor: pointer;"  class="w3-third w3-btn">
                                    <a style="color:#000;" href="insertsize.php"><b>Add New Size</b></a>
                                </div>
                                 
                            </div>

                            <div class="w3-row-padding w3-padding-24" id="misssize">
                                
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