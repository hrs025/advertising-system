<?php
require_once 'connection.php';
$_SESSION['page'] = "feedback";

$msg = 0;
if(isset($_POST['submit']))
{
    $feedname = $_POST['feedname'];
    $feedmsg = $_POST['feedmsg'];
    $feel = $_POST['feel'];
    
    $feedback = mysqli_query($con,"insert into feedback values(0,'$feedname','$feedmsg','$feel')");
    if($feedback)
    {
        $msg = 1;
    }
}
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
                    <span class="w3-text-black w3-large headingPolicy" style="font-weight: bold;">Feedback&nbsp;&nbsp;</span>
                    <span>
                    <?php
                    if($msg == 1)
                    {
                        echo "<font class='w3-text-green'>Thank you for feedback</font>";
                    }
                    ?>    

                    </span>
                    <div class="w3-row w3-padding-16">
                        <div style="padding-top:20px;" class="w3-half" >
                            <form method="post">
                            <table class="w3-table w3-text-black w3-medium">
                                <tr>
                                    <td><i class="fa fa-list"></i></td>
                                    <td>
                                        <select required="" name="feel" class="w3-input">
                                            <option value="excellent">Excellent</option>
                                            <option value="good" selected="">Good</option>
                                            <option value="average">Average</option>
                                            <option value="poor">Poor</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td><i class="fa fa-book"></i></td>
                                    <td>
                                        <input type="text" name="feedname" placeholder="Subject" required class="w3-input" required=""/>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td><i class="fa fa-edit"></i></td>
                                    <td>
                                        <textarea name="feedmsg" class="w3-input" required="" placeholder="Message"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <button type="submit" name="submit" class="w3-button w3-card-2 w3-medium" style="width:86%;margin-left: 14%;padding: 2.5%;"><i class="fa fa-paper-plane"></i> Submit</button>
                                    </td>
                                </tr>
                            </table>
                            </form>
                        </div>
                        <div class="w3-half">
                            <img src="logo/feedback.jpg" style="width: 90%;height: 43%;" />
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

