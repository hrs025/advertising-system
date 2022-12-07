<?php

$prefix = "";
$wel=  mysqli_query($con,"select * from registration where userid like '$_SESSION[user]'");
$wel1=  mysqli_fetch_array($wel);
if($wel1['gender'] == 1)
{
    $prefix = "Mr. ";
}
else if($wel1['gender'] == 2)
{
    $prefix = "Ms. ";
}
else
{
    $prefix = "Mr. / Miss. ";
}
$msg = "";
if($wel1['type'] == 0)
{
    $msg = " In Admin Reception";
}
else
{
    $msg = "";
}


$get = mysqli_query($con,"select * from logintime where userid='$_SESSION[user]'");
$gettime = mysqli_fetch_array($get);
$dt=substr($gettime['logindate'],8,2);
$mn=substr($gettime['logindate'],5,2);
$yr=substr($gettime['logindate'],0,4);
$logtime = $dt."-".$mn."-".$yr." | ".$gettime['logintime'];
?>

<div>
    <div class="w3-half">
        <font style="font-size: 20px;">W</font>elcome <?php echo $prefix." ".$wel1['username'].$msg; ?> 
    </div>
    <div class="w3-half">
        <font class="w3-right"><font style="font-weight: bold;">Last Login Date & Time :</font> <?php echo $logtime; ?></font>
    </div>

</div>