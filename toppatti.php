<div id="top-bar">
    <div class="container-fluid">
        <ul class="contact-info" style="width:70%">
            <li style="margin-top: -5px;margin-left: 8%;"><a href="index.php" title="AMS | Indian Outdoor Advertising Online Booking"><img src="logo/ams.png" style="width:130px;height:43px;" /></a></li>

            
             
        </ul>
        <ul class="top-links">
            <?php
              if(@$_SESSION['user']=="")
              {      
                 echo "<li><i class='fa fa-key'></i> <a href='sign.php' style='font-weight: 700' class='login'>Login & Sign Up &nbsp;&nbsp;</a></li>";
                 
              }
              else
              {
                  if($_SESSION['type']==0)
                  {
                    ?>  
                        <li><i class='fa fa-user'></i> <a  style='font-weight: 700'href='adminpanel.php' class='login'>My Account</a></li>
                       <li> <i class='fa fa-power-off'></i><a style='font-weight: 700' href='logout.php' class='login'>Logout</a></li>
                       
                  <?php
                   }
                         
                  if($_SESSION['type']==2)
                  {
                    ?>  
                        
                       <li><i class='fa fa-user'></i> <a style='font-weight: 700' href='profile.php' class='login'>My Account</a></li>
                       <li> <i class='fa fa-power-off'></i><a href='logout.php' style='font-weight: 700' class='login'>Logout</a></li>
                  <?php
                   }
                 
              }   
            ?>
            
        </ul>
    </div>
</div>