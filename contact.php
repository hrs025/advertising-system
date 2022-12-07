<?php
require_once 'connection.php';
$_SESSION['page'] = "contact";

$msg = 0;
if(isset($_POST['submit']))
{
    $contactname = $_POST['contactname'];
    $contactemail = $_POST['contactemail'];
    $contact_subject = $_POST['contact_subject'];
    $contactmsg = $_POST['contactmsg'];
    
    $contact = mysqli_query($con,"insert into contact values(0,'$contactname','$contactemail','$contactmsg','$contact_subject')");
    if($contact)
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
              <div class="container-fluid w3-padding-16">
                <div class="container w3-white w3-padding-16">
                    <span class="w3-text-black w3-large headingPolicy" style="font-weight: bold;">Contact Us&nbsp;&nbsp;</span>
                    <span>
                    <?php
                    if($msg == 1)
                    {
                        echo "<font class='w3-text-green'>Thanks for subscribing contact</font>";
                    }
                    ?>    

                    </span>
                    <div class="w3-row w3-padding-16">
                        <div class="w3-half">
                            <form method="post">
                            <table class="w3-table w3-text-black w3-medium">
                                <tr>
                                    <td><i class="fa fa-user"></i></td>
                                    <td>
                                        <input type="text" name="contactname" placeholder="Name" required class="w3-input" required="" pattern="[A-Za-z ]+" title="Only Alphabet And Space Allowed..." />
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td><i class="fa fa-envelope"></i></td>
                                    <td>
                                        <input type="email" name="contactemail" placeholder="Email" required class="w3-input"  required="" />
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td><i class="fa fa-book"></i></td>
                                    <td>
                                        <input type="text" name="contact_subject" placeholder="Subject" required class="w3-input" required=""/>
                                    </td>
                                </tr>
                                <tr><td></td></tr>
                                <tr>
                                    <td><i class="fa fa-edit"></i></td>
                                    <td>
                                        <textarea name="contactmsg" class="w3-input" required="" placeholder="Message"></textarea>
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
                        <div  class="w3-half">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d235014.2579193776!2d72.43965694318824!3d23.020181763930605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e848aba5bd449%3A0x4fcedd11614f6516!2sAhmedabad%2C%20Gujarat!5e0!3m2!1sen!2sin!4v1580464446188!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
                        </div>
                    </div>
                    <hr style="border:0.3px solid #666666;" />
                    <div class="w3-row w3-padding-16">
                        

                        <ul class="w3-ul">
                                <li style="border:none;display: inline;"><i class="fa fa-institution"></i>
                            Ahmedabad, Gujarat</li>
                                <li style="border:none;display: inline;padding-left: 8%;"><i class="fa fa-phone"></i>
                            &nbsp;+91 9500000005</li>
                            <li style="display: inline;padding-left: 8%;"><i class="fa fa-envelope"></i>
                            &nbsp;<a style="text-decoration: none;color:black;" href="https://accounts.google.com/ServiceLogin?sacu=1#identifier"> l12698@gmail.com</a></li>
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

