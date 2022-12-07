<?php
require_once 'connection.php';
$_SESSION['page'] = 'home';


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

        <?php
        require_once 'slider.php';
        ?>
        <div  class="container" style="padding-top:2%;">
            
        <div class="row">
          <div class="col-sm-3">  
            <img src="banner/5.jpg" style="width:100%;height:50%; ">
          </div>
          <div class="col-sm-3">  
            <img src="banner/6.jpg" style="width:100%;height:41%;padding-top:56px; ">
          </div>
          <div class="col-sm-3"  >  
            <img src="banner/7.jpg" style="width:100%;height:41%;padding-top:50px;">
          </div>
          <div class="col-sm-3" >  
            <img src="banner/8.jpg" style="width:100%;height:41%;padding-top:51px;"">
          </div>
      </div>
  </div>
  <div style="padding-top:2%;"></div>
   <?php
        require_once 'socialicon.php';
        ?>

        <?php
        require_once 'footer.php';
        ?>
           
    </body>

</html>