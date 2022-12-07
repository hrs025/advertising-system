<?php
require_once 'connection.php';
$_SESSION['page'] = "sitemap";

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
              <div  class="container-fluid w3-padding-16">
                <div class="container w3-white w3-padding-16">
                    <span class="w3-text-black w3-large headingPolicy" style="font-weight: bold;">Site Map of Mera Hoardings&nbsp;&nbsp;</span>
                    </span>
                    <div class="w3-row w3-padding-16" style="height:70%;background-image: url('images/map.png');">
                        <ul class="w3-ul">
                            <li class="w3-hover-light-grey"><a href="index.php" class="w3-text-black">Home</a></li>
                            <li class="w3-hover-light-grey"><a href="about.php" class="w3-text-black">About Us</a></li>
                            <li class="w3-hover-light-grey"><a href="banner.php" class="w3-text-black">Banners</a></li>
                            <li class="w3-hover-light-grey"><a href="contact.php" class="w3-text-black">Contact</a></li>
                            <li class="w3-hover-light-grey"><a href="feedback.php" class="w3-text-black">Feedback</a></li>
                            <li class="w3-hover-light-grey"><a href="sign.php" class="w3-text-black">Login & Sign Up</a></li>
                            <li class="w3-hover-light-grey"><a href="terms.php" class="w3-text-black">Terms of use</a></li>
                            <li class="w3-hover-light-grey"><a href="privacypolicy.php" class="w3-text-black">Privacy</a></li>
                            <li class="w3-hover-light-grey"><a href="service.php" class="w3-text-black">Services</a></li>
                            <li class="w3-hover-light-grey"><a href="sitemap.php" class="w3-text-black">Site Map</a></li>
                        </ul>
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

