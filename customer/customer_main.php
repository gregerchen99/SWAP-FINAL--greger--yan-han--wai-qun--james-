<?php 
session_start();

$con = mysqli_connect("localhost","root","","encryption");
if (!$con)
{
	die('Could not connect: '. mysqli_connect_errno()); //return error if connect fails
}

$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
	$u = "SELECT * FROM `customer_info` WHERE `cust_name` = '$user'";
	$valid = $con->query($u);
	if($valid->num_rows > 0)
	{

	}
	else
	{
		 header("Refresh:0; http://localhost/CRUD/");
    	 session_unset();
    	session_destroy();
    	exit();
	}
} else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

echo "You are signed in as " . $user . ".<br>"; 
?>

<html>
	<form action="http://localhost/CRUD/login_customer.php" method="post">
	<input type="Submit" name="cmdlogout" value="Logout">
	</form>
</html>

<?php
echo "Account details:";
$sql = mysqli_query($con,"SELECT `cust_id`,`cust_name`,`cust_email`,`cust_hp`,`Address`,`Postalcode` FROM `customer_info` WHERE `cust_name`= '$user'");

$encryptNum = mysqli_query($con,"SELECT `cust_hp` FROM `customer_info` WHERE `cust_name`= '$user'");
while ($row = $encryptNum->fetch_assoc()){
	$encryptNum2 = $row['cust_hp'];
}
$key = "potato1234potato";
$initVector = "potato1234potato";
$decryptNum = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encryptNum2, MCRYPT_MODE_CFB, $initVector);
//password
$creationdate = mysqli_query($con,"SELECT `last_update` FROM `password_expiry` WHERE `username`= '$user'");

while ($row = $creationdate->fetch_assoc()) {
  $creationdate1 =  $row['last_update'];
}

$currentdate = date("Y-m-d");
$diff = abs(strtotime($creationdate1) - strtotime($currentdate));
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
if($days > '23'){
 echo "<br>";
 echo "Your password is expiring. Please change it as soon as possible";
}

echo "<table border='1'>
<tr>
<th>cust_id</th>
<th>cust_name</th>
<th>cust_email</th>
<th>cust_hp</th>
<th>Address</th>
<th>Postalcode</th>
</tr>";

while ($row = mysqli_fetch_array($sql))
{
  echo "<tr>";
  echo "<td>" . $row['cust_id'] . "</td>";
  echo "<td>" . $row['cust_name'] . "</td>";
  echo "<td>" . $row['cust_email'] . "</td>";
  echo "<td>" . $decryptNum . "</td>";
  echo "<td>" . $row['Address'] . "</td>";
  echo "<td>" . $row['Postalcode'] . "</td>";
  echo "</tr>";
}

echo "</table>";
echo "<br>";
?>

<html>
<body>
	<a href="customer_update.php">
	<input type="Submit" value="Update account">

	<a href="customer_delete.php">
	<input type="Submit" value="Deactivate account">
	</a>
</body>
</html>





