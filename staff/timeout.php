<?php
  
$con = mysqli_connect("localhost","root","","encryption");
if(!$con)
{
  die('Could not connect: '.mysqli_connect_errno());
}

echo 'Session has timed out ! Going Back to Login';
header("Refresh:2; http://localhost/CRUD/login_staff.php");//to change
?>