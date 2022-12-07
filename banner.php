<?php
require_once 'connection.php';
$_SESSION['page']="banner";
$_SESSION['ch']="";


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

        
        <section style="background: #F1F3F6;">
            <br><br>
            <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <a href="banner/17.jpeg" class="thumbnail">
                    <img src="banner/17.jpeg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/11.jpeg" class="thumbnail">
                    <img src="banner/11.jpeg" style="width:150px;height:150px" class="img-thumbnail">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/16.jpeg" class="thumbnail">
                    <img src="banner/16.jpeg" class="img-thumbnail"
                     style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/15.jpeg" class="thumbnail">
                    <img src="banner/15.jpeg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/14.jpeg" class="thumbnail">
                    <img src="banner/14.jpeg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/12.jpeg" class="thumbnail">
                    <img src="banner/12.jpeg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/10.jpg" class="thumbnail">
                    <img src="banner/10.jpg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
                </div>
                <div class="col-sm-3">
                    <a href="banner/5.jpg" class="thumbnail">
                    <img src="banner/5.jpg" class="img-thumbnail" style="width:150px;height:150px">
                </a>
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