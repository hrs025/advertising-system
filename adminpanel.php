<?php
require_once 'connection.php';
$_SESSION['page']="adminpanel";
require_once './adminsecurity.php';

// Product Chart
//Counter
$city = mysqli_query($con,"select count(*) as city from city where citydel=0");
$city1 = mysqli_fetch_array($city);
$area = mysqli_query($con,"select count(*) as area from area where areadel=0");
$area1 = mysqli_fetch_array($area);
$customer = mysqli_query($con,"select count(*) as customer from registration where type=2");
$customer1 = mysqli_fetch_array($customer);
$contact = mysqli_query($con,"select count(*) as contact from contact");
$contact1 = mysqli_fetch_array($contact);
$feedback = mysqli_query($con,"select count(*) as feedback from feedback");
$feedback1 = mysqli_fetch_array($feedback);


?>
<!DOCTYPE html5>
<html>

    <?php
    require_once 'head.php';
    ?>

    <body onload="getCounterChart('<?php echo $city1["city"]; ?>','<?php echo $area1["area"]; ?>','<?php echo $customer1["customer"]; ?>','<?php echo $contact1["contact"]; ?>','<?php echo $feedback1["feedback"]; ?>');">  

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
                            <div class="w3-row" id="counter_chart">
                                <!-- Counter Chart -->
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