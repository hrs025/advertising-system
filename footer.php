<?php
if(session_status()==PHP_SESSION_NONE)
{
    session_start();
}
$con = mysqli_connect("localhost", "root", "","ams");
if (!$con) 
{
    die("Not Connected With Database");
}
require_once 'head.php';

$e=0;
$sendd=0;
if(isset($_REQUEST['emailsubscribe']))
{
    $in=  mysqli_query($con,"select * from emailsub where email='$_REQUEST[emailsub]'");
    $in1=mysqli_fetch_array($in);

    if($in1[0]!="")
    {
        $e=1;
    }  
    else
    {
        $in=  mysqli_query($con,"insert into emailsub values(0,'$_REQUEST[emailsub]')");
        $sendd=1;
    }
}
?>

<section id="footer-wrapper" class="default-margin">
    <footer class="row" id="footer" >
        <div class="container">
            <div class="row borderdidhi" style="margin:0;">
                <div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
                    <div>
                        <h5 style="">POLICY</h5>
                        <ul>
                            <li class="policy">
                                <div><img style="width: 5%;" src="adminsideimage/terms.png"><a href="terms.php">&nbsp;&nbsp;Terms of use</a></div>
                                <div><img  style="width: 5%;" src="adminsideimage/privatep.png"><a href="privacypolicy.php">&nbsp;&nbsp;Privacy</a></div>
                                <div><img style="width: 5%;" src="adminsideimage/service.png"><a href="service.php">&nbsp;&nbsp;Services</a></div>
                            </li>
                        </ul>
                    </div>
                    <div class="row" style="margin:0;">
                        <h5 style="margin-bottom: 0px;"><i>Email</i> Subscrible</h5>
                        <form class="form-group" method="post" name="emailsub" action="">
                            <div class="input-group col-md-9 col-xs-9 col-sm-9">   
                                  
                                <input type="email" class="form-control" required="" name="emailsub" placeholder="Enter Email For Latest Updates" style="background-color: rgba(0,0,0,0.2);color: #fff;border:1px solid #fff;" />
                                <div class="input-group-addon" style="background-color: #fff;"><button title="Newsletter" type="submit" name="emailsubscribe" class="emailsub"><font style="color: #000;"><i class="fa fa-rss"></i></font></button></div>
                            </div>
                            <div>
                                <?php
                                if($e==1)
                                {
                                    echo "<font style='color:red;'>Already Exist</font>";
                                }
                                if($sendd==1)
                                {
                                    echo "<font style='color:#01c38e;'>Thank you for Email Subscribe.</font>";
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 col-xs-12 col-lg-4 col-sm-12">
                    
                    <h5><i>Contact</i> Us</h5>
                    <dl class="w3-text-white">
                        <ul class="w3-ul">
                            <li style="border:none;"><i class="fa fa-institution"></i>
                            Ahmedabad, Gujarat</li>
                                <li style="border:none;"><i class="fa fa-fax"></i>
                            &nbsp;+91 9500000005</li>
                                
                            <li><i class="fa fa-envelope"></i>
                            &nbsp;<a style="text-decoration: none;color:#fff" href="https://accounts.google.com/ServiceLogin?sacu=1#identifier"> l12698@gmail.com</a></li>
                        </ul>
                        
                    </dl>



                </div>
                <div class="col-md-4 col-xs-12 col-lg-4 col-sm-12 payment">
                    <h5 style="margin: 0%;"><i>Payment</i> Method</h5><br/>
                    <div class="w3-text-white">
                        <font><i class="fa fa-arrow-right" style="font-size:14px;"></i></font> &nbsp;&nbsp;Card Payments Comming Soon...
                    </div>

                    <div class="row" style="margin:0;">
                        <br>
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/cash.png" title="COD" style="cursor: pointer" />
                        </div>
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/mastercard.png" title="MasterCard" style="cursor: pointer" />
                        </div>
                         
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/visa_2.png" title="Visa" style="cursor: pointer" />
                        </div>
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/rupay_2.png" title="Rupay" style="cursor: pointer" />
                        </div> 
                    </div>
                    <div class="w3-text-white">
                        <font><i class="fa fa-arrow-right" style="font-size:14px;" ></i> </font>&nbsp;&nbsp;Alternative Payments    Comming Soon...
                    </div>

                    <div class="row" style="margin:0;">
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/cod.png" title="Cash On Delivery" style="cursor: pointer" />
                        </div>
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/net-banking.png" title="Net Banking" style="cursor: pointer" />
                        </div>
                        <div class="col-md-3 col-xs-3 col-lg-3 col-sm-3">
                            <img class="img img-responsive" src="images/direct2.png" title="Direct Debit" style="cursor: pointer" />
                        </div> 
                    </div>
                </div>
            </div>  
        </div>

    </footer>
</section>

<div class="container-fluid footercopy">
    <div class="row" style="margin: 0;">
        <div class="col-md-7 col-xs-10 col-sm-10 col-md-offset-3">
            <p style="font-weight: 100;font-size: 14px;">Copyright &copy; 2019-20 AMS All Rights Reserved.</p>
        </div>
        <div class="col-md-1 col-sm-2 col-xs-2 col-md-offset-1 cd-top">
            <img src="images/top.png" title="Bottom To Top"/>
        </div>
    </div>
</div>



