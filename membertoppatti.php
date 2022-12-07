<div class="col-md-12 col-sm-12 col-xs-12 adminpatti">
                                <div class="col-md-8 col-xs-8 col-sm-8 welcome animated fadeInRight">
                                    <font><i style="font-size: 18px;" class="fa fa-database"></i>&nbsp; Mostly Welcome,</font>Once Again Mr/Miss.
                                       <?php
                                       $wel=  mysqli_query($con,"select * from registration where userid like '$_SESSION[user]'");
                                       $wel1=  mysqli_fetch_array($wel);
                                       echo $wel1[0];
                                       ?>
                                    In Member Reception
                                </div>
                                <div class="col-md-4 col-xs-4 col-sm-4 lastlogin animated rollIn" >
                                    <font>Your Last Visiting Website Session Date&nbsp;|&nbsp;Time&nbsp;:</font><br/>
                                    <i class="fa fa-clock-o"></i>&nbsp;
                                    <?php
                                    $get = mysqli_query($con,"select * from logintime where userid='$_SESSION[user]'");
                                    $gettime = mysqli_fetch_array($get);
                                    $dt=substr($gettime[1],8,2);
                                    $mn=substr($gettime[1],5,2);
                                    $yr=substr($gettime[1],0,4);
                                    echo $dt."-";
                                    echo $mn."-";
                                    echo $yr."&nbsp;|&nbsp;";
                                    echo $gettime[2];
                                    ?>
                                    
                                </div>
                            </div>