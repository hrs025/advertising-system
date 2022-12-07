<?php
require_once 'connection.php';
$_SESSION['page']="useroderpamphelt";
require_once './adminsecurity.php';
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
                            
                            <div class="w3-row-padding w3-padding-24" id="misspackage" >
                            <table class="table table-hover">
                                <thead>
                                    <tr class="w3-blue">
                                        <th>User Name </th>
                                        <th>Pamphlet</th>
                                        <th>City</th>
                                        <th>Area</th>
                                        <th>No. Of Pamphlet</th> 
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Create Date</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <?php 
                                $selorder = "SELECT up.`pamphletID`,up.no_of_pamphlet,r.username,c.cityname,a.areaname,up.`pamphletImg`,up.`price`,up.status,up.`create_date` FROM user_pamphlet_order up 
JOIN registration r on up.userid = r.userid 
JOIN city c on c.cityid = up.`city_Id` 
JOIN area a on a.areaid = up.`aeria_Id";
                    $selorderResult = mysqli_query($con,$selorder)
                    or die("Error: ".mysqli_error($con));
                           while ($order = mysqli_fetch_array($selorderResult))
                           {  ?>
                            <tr>
                                <td><?php echo $order['username'];?></td>
                                <td width="10%"><img src="userPamphlet/<?php echo $order['pamphletImg'];?>"/></td>
                                
                                <td><?php echo $order['cityname'];?></td>
                                <td><?php echo $order['areaname'];?></td>
                                 <td><?php echo $order['no_of_pamphlet'];?></td>
                                <td><?php echo $order['price'];?></td>
                                <td><?php echo $order['status']? "<font style='color:green'><b>Active</b></font>" : "In-Active";?></td>
                                <td><?php echo $order['create_date'];?></td>
                                <td><a href="deleteuseroderpamphlet.php?userId=<?php echo $order['pamphletID']; ?>"><button type="button" class="btn btn-warning">Delete</button></a></td>
                                <td><a href="updateuseroderpamphletstatus.php?userId=<?php echo $order['pamphletID']; ?>" class="btn btn-success">Update Status</a></td>

                            </tr>
                           <?php } ?>
                            </table>
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