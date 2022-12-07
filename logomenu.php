<header id="header">
    <div class="container">
        <nav class="navbar yamm navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars fa-2x"></i>
                    </button> 
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        <?php
                        if ($_SESSION['page']=='home') {
                            ?>
                            <li class="menuback"><a href="index.php" class="navbar-toggle">Home</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="index.php" class="navbar-toggle">Home</a></li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($_SESSION['page'] == 'about') {
                            ?>
                            <li class="menuback"><a href="about.php" class="navbar-toggle" >About Us</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="about.php" class="navbar-toggle">About Us</a></li>
                            <?php
                        }
                        ?>
                          
                            
                    <?php
                    if ($_SESSION['page'] == "banner") {
                        ?>
                            <li class="menuback"><a href="banner.php">Banner</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="banner.php">Banner</a></li>
                            <?php
                        }
                        ?>

                    <?php
                    if ($_SESSION['page'] == "contact") {
                        ?>
                            <li class="menuback"><a href="contact.php">Contact</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="contact.php">Contact</a></li>
                            <?php
                        }
                        ?>

                        <?php
                        if ($_SESSION['page'] == "feedback") {
                            ?>
                            <li class="menuback"><a href="feedback.php">feedback</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="feedback.php">feedback</a></li>
                            <?php
                        }
                        ?>



                        <?php
                        if ($_SESSION['page'] == 'sitemap') {
                            ?>
                            <li class="menuback"><a href="sitemap.php" class="navbar-toggle">site map</a></li>
                            <?php
                        } else {
                            ?>
                            <li><a href="sitemap.php" class="navbar-toggle">site map</a></li>
                            <?php
                        }
                        ?>

<!--                      <li>
                                        <form id="nav_search_form" action="http://speed-up.borisolhor.com/" method="get"><input id="nav_search" name="nav_search" type="text" placeholder="search..."><button type="submit"><i class="fa fa-search"></i></button></form>
                                        <a href="javascript:void(0)" class="open_search nav_search_control"  ><i class="fa fa-search"></i></a>
                                    </li>
                                    -->
                                    
                                    

                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>