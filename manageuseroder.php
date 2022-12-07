<?php
require_once 'connection.php';
$_SESSION['page']="useroder";
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
                                        <th>Banner</th>
                                        <th>Pachage</th>
                                        <th>City</th>
                                        <th>Area</th>
                                        <th>Hoarding Size</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <?php 
                                $selorder = "SELECT u.`user_order_id`,p.packagename,r.username,s.size,c.cityname,a.areaname,u.`banner_img`,u.`price`,u.`status` FROM `user_order` u 
JOIN registration r on u.userid = r.userid
JOIN package p on p.packageid = u.`package_id`
JOIN size s on s.size_id = u.`size_id`
JOIN city  c on c.cityid = u.`city_Id`
JOIN area a on a.areaid = u.`aeria_Id`";
                    $selorderResult = mysqli_query($con,$selorder);
                           while ($order = mysqli_fetch_array($selorderResult))
                           {  ?>
                            <tr>
                                <td><?php echo $order['username'];?></td>
                                <td><img src="userBanner/<?php echo $order['banner_img'];?>" width="40%"/></td>
                                <td><?php echo $order['packagename'];?></td>
                                <td><?php echo $order['cityname'];?></td>
                                <td><?php echo $order['areaname'];?></td>
                                <td><?php echo $order['size'];?></td>
                                <td><?php echo $order['price'];?></td>
                                <td><?php echo $order['status']? "<font style='color:green'><b>Active</b></font>" : "In-Active";?></td>
                                <td><a href="deleteuseroder.php?userId=<?php echo $order['user_order_id']; ?>"><button type="button" class="btn btn-warning">Delete</button></a></td>
                                <td><a href="updateuseroderstatus.php?userId=<?php echo $order['user_order_id']; ?>" class="btn btn-success">Update Status</a></td>

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