<!-- /. NAV TOP  -->
                <nav class="navbar-default navbar-side" role="navigation" style="margin-top: 2%;margin-left: -8px;">
                <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="<?php echo $wel1['profile']; ?>" class="user-image img-responsive"/>
					</li>
				
                    <li>
                        <?php
                        if($_SESSION['page'] == "profile")
                        {
                            echo "<a class='active-menu'  href='profile.php'><i class='fa fa-user fa-3x'></i><font>Profile Information</font></a>";
                        }
                        else
                        {
                            echo "<a href='profile.php'><i class='fa fa-user fa-3x'></i><font>Profile Information</font></a>";
                        }
                        ?>   
                    </li>
                    
                    <li>
                        <?php
                        if($_SESSION['page'] == "manageBanner")
                        {
                            echo "<a class='active-menu'  href='manage_banner.php'><i class='fa fa-plus fa-3x'></i><font>Manage Hoarding</font></a>";
                        }
                        else
                        {
                            echo "<a href='manage_banner.php'><i class='fa fa-plus fa-3x'></i><font>Manage Hoarding</font></a>";
                        }
                        ?>   
                    </li>

                    <li>
                        <?php
                        if($_SESSION['page'] == "manageBanner")
                        {
                            echo "<a class='active-menu'  href='manage_pamphlet.php'><i class='fa fa-plus fa-3x'></i><font>Manage Pamphlet</font></a>";
                        }
                        else
                        {
                            echo "<a href='manage_pamphlet.php'><i class='fa fa-plus fa-3x'></i><font>Manage Pamphlet</font></a>";
                        }
                        ?>   
                    </li>
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->