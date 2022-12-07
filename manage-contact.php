<?php
require_once 'connection.php';
$_SESSION['page']="managecontact";
require_once './adminsecurity.php';
?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="miss('contact','display');">  

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
                                <div>
                                    <b>Contact Information</b>
                                </div>
                            </div>

                            <div class="w3-row-padding w3-padding-24" id="misscontact" >
                                Contact
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