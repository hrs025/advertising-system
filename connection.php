<?php
if(session_status()==PHP_SESSION_NONE)
{
    session_start();
}

require_once'PHPMail.php';

$con = mysqli_connect("localhost", "root", "","ams");
if (!$con) 
{
    die("Not Connected With Database");
}
?> 