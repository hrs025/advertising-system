
                <nav class="navbar-default navbar-side" role="navigation" style="margin-top: 2%;margin-left: -8px;">
                <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="<?php echo $wel1['profile']; ?>" style="width:55%;height: 35%;" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <?php
                        if($_SESSION['page'] == "adminpanel")
                        {
                            echo "<a class='active-menu'  href='adminpanel.php'><i class='fa fa-dashboard'></i><font>Dashboard</font></a>";
                        }
                        else
                        {
                            echo "<a href='adminpanel.php'><i class='fa fa-dashboard'></i><font>Dashboard</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "profile")
                        {
                            echo "<a class='active-menu'  href='profile.php'><i class='fa fa-user'></i><font>Profile Information</font></a>";
                        }
                        else
                        {
                            echo "<a href='profile.php'><i class='fa fa-user'></i><font>Profile Information</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "city")
                        {
                            echo "<a class='active-menu'  href='managecity.php'><i class='fa fa-map-marker'></i><font>Manage City</font></a>";
                        }
                        else
                        {
                            echo "<a href='managecity.php'><i class='fa fa-map-marker'></i><font>Manage City</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "area")
                        {
                            echo "<a class='active-menu'  href='managearea.php'><i class='fa fa-building'></i><font>Manage Area</font></a>";
                        }
                        else
                        {
                            echo "<a href='managearea.php'><i class='fa fa-building'></i><font>Manage Area</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "package")
                        {
                            echo "<a class='active-menu'  href='managepackage.php'><i class='fa fa-cubes fa-3x'></i><font>Manage Packages</font></a>";
                        }
                        else
                        {
                            echo "<a href='managepackage.php'><i class='fa fa-cubes fa-3x'></i><font>Manage Packages</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "size")
                        {
                            echo "<a class='active-menu'  href='managesize.php'><i class='fa fa-cubes fa-3x'></i><font>Manage Sizes</font></a>";
                        }
                        else
                        {
                            echo "<a href='managesize.php'><i class='fa fa-cubes fa-3x'></i><font>Manage Sizes</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "useroder")
                        {
                            echo "<a class='active-menu'  href='manageuseroder.php'><i class='fa fa-cubes fa-3x'></i><font>
                            Manage User Hoarding 
                            </font></a>";
                        }
                        else
                        {
                            echo "<a href='manageuseroder.php'><i class='fa fa-cubes fa-3x'></i><font>Manage User Oder Hoarding </font></a>";
                        }
                        ?>   
                    </li>
                     <li>
                        <?php
                        if($_SESSION['page'] == "useroderpamphelt")
                        {
                            echo "<a class='active-menu'  href='manageuseroderpamphlet.php'><i class='fa fa-cubes fa-3x'></i><font>
                            Manage User Order Pamphlet 
                            </font></a>";
                        }
                        else
                        {
                            echo "<a href='manageuseroderpamphlet.php'><i class='fa fa-cubes fa-3x'></i><font>Manage User Oder Pamphlet </font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "managecustomer")
                        {
                            echo "<a class='active-menu'  href='manage-customer.php'><i class='fa fa-users fa-3x'></i><font>Manage Customer</font></a>";
                        }
                        else
                        {
                            echo "<a href='manage-customer.php'><i class='fa fa-users fa-3x'></i><font>Manage Customer</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "managecontact")
                        {
                            echo "<a class='active-menu'  href='manage-contact.php'><i class='fa fa-contao fa-3x'></i><font>Manage Contact</font></a>";
                        }
                        else
                        {
                            echo "<a href='manage-contact.php'><i class='fa fa-contao fa-3x'></i><font>Manage Contact</font></a>";
                        }
                        ?>   
                    </li>
                    <li>
                        <?php
                        if($_SESSION['page'] == "managefeedback")
                        {
                            echo "<a class='active-menu'  href='manage-feedback.php'><i class='fa fa-comments fa-3x'></i><font>Manage Feedback</font></a>";
                        }
                        else
                        {
                            echo "<a href='manage-feedback.php'><i class='fa fa-comments fa-3x'></i><font>Manage Feedback</font></a>";
                        }
                        ?>   
                    </li>
                </ul>
               
            </div>
            
        </nav>  
