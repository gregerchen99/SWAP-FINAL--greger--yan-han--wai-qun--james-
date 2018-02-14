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

$encryptNum = mysqli_query($con,"SELECT `cust_hp` FROM `customer_info` WHERE `cust_name`= '$user'");
while ($row = $encryptNum->fetch_assoc()){
	$encryptNum2 = $row['cust_hp'];
}
$key = "potato1234potato";
$initVector = "potato1234potato";
$decryptNum = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encryptNum2, MCRYPT_MODE_CFB, $initVector);
//password

$sql = mysqli_query($con,"SELECT `cust_id`,`cust_name`,`cust_email`,`cust_hp`,`Address`, `Postalcode` FROM `customer_info` WHERE `cust_name`= '$user'");

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

<!DOCTYPE html>
<html>
<body>
	<form action="customer_update1.php" method="post">

		
		Change your username(Relogin required) <input type="Username" name="Username" id="Username" placeholder="Username" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Username must begin with a character">
		<br>
		Change your password(8 Characters long, 1 uppercase, 1 lowercase, 1 numberic character) <input type="password" name="Password" id="Password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
		<br>
		Change your Email <input type="email" name="Email" id="Email" placeholder="example@domain.com" required>
		<br>
		Change your Mobile Phone(format: xxxx-xxxx) <input type="tel" min="0" name="Contact" id="Contact" placeholder="xxxx-xxxx" pattern="[89]\d{3}-\d{4}$" required title="Number must start with 8 or 9">
		<br>
		<label for="Address">Address</label>
		<input type="Address" name="Address" id="Address" placeholder="Address" required>
		<br>

		<label for="Postalcode">Postal code (s)</label>
		<input type="tel" name="Postalcode" id="Postalcode" placeholder="Postalcode" pattern="^\d{6}" required>
		<br>
		<br>
		<input type="submit" value="Update">
	</form>

	<form action="customer_main.php" method="post">
	<input type="Submit" value="Back">
	</form>
</body>
</html>