<?php
require_once './connection.php';

if($_SESSION['user']=="")
{
    header("location:index.php");
}
if($_SESSION['type']!=2)
{
   header("location:sign.php"); 
}
?>