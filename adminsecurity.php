<?php
require_once './connection.php';
if($_SESSION['user']=="")
{
    header("location:index.php");
}
if($_SESSION['type']!=0)
{
    header("location:sign.php");
}

?>