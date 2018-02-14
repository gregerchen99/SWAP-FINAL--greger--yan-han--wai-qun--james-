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

echo "Are you sure you would like to disable the account: ". $user. "<br>"; 
echo "<br>";
?>

<!DOCTYPE html>
<html>
<body>
	<form action="customer_delete1.php" method="post">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
		<label for="Password">Please enter your password:</label>
		<br>
		<input type="password" name="Password" id="Password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
		<br>
		<br>

		<div class="g-recaptcha" data-sitekey="6LeoTEAUAAAAAB0zFYqh4-JRFximwWAKo-D6stv4"></div>
		<br>
		<input type="submit" value="Deactivate">
	</form>

	<form action="customer_main.php" method="post">
		<input type="Submit" value="Back">
	</form>
</body>
</html>
