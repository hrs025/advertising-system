<?php
require_once 'connection.php';
$updatetime=  mysqli_query($con,"update logintime set logindate='$_SESSION[date]',logintime='$_SESSION[time]' where userid='$_SESSION[user]'");

unset($_SESSION['user']);
unset($_SESSION['type']);
unset($_SESSION['date']);
unset($_SESSION['time']);
header("location:sign.php");
?>