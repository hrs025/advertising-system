<?php
require_once 'connection.php';
require_once './adminsecurity.php';
$_SESSION['page']="";


?>

<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="miss('review','display');">  

        <div id="header-wrapper">

            <?php
            require_once 'toppatti.php';
            require_once 'logomenu.php';
            ?>

        </div>


        <section style="background: rgba(0,0,0,0.01);">
            <div class="container-fluid" id="manageuser">
                <div class="row adminmain">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="row" style="margin: 0;padding: 0;">
                            <?php
                                        require_once './admintoppatti.php';
                            ?>
 
                            <div class="col-md-12 col-sm-12 col-xs-12 adminsite  ">
                                &nbsp;&nbsp;&nbsp;&nbsp;<font> <a href="adminpanel.php"><i class="fa fa-home"></i>&nbsp;Home</a> > <a href="managereview.php">Service Provider Review</a> </font>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 adminsite" id="moto">
                              
                                <div class="col-md-12 col-sm-12 col-xs-12 citycontain" id="missreview">
     
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

