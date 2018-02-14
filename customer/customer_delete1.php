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

date_default_timezone_set('Singapore');
$Password = mysqli_real_escape_string($con, $_REQUEST['Password']);
//user input
//Logging variables
$query_date = date('Y-m-d H:i:s');
$logevent =  "Customer: Successful account deactivated";
$logevent2 = "Customer: Deactivate failed; Connection error";
$logevent3 = "Customer: Deactivate failed; Recaptcha error";
$logevent4 = "Customer: Deactivate failed; Password incorrect";
//$logevent3 = "Customer: Login attempt failed";
//Recaptcha variables
$recaptcha_secret = "6LeoTEAUAAAAAGCvy9ckWncD99XglkvSrvXr5vm_";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
$response = json_decode($response, true);


$sql = mysqli_query($con, "SELECT `cust_pw` FROM `customer_info` WHERE `cust_name` = '$user'");

while($row = mysqli_fetch_array($sql))
{
	$hash = $row['cust_pw'];
}
if(password_verify($Password, $hash))
{
	$sql1 = mysqli_query($con, "DELETE FROM `customer_info` WHERE `cust_name` = '$user'");
	if($response["success"] === true)
	{
		if(mysqli_query($con, $sql1))
		{
			$sql3 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent2','$query_date')");
			echo "ERROR: An error occured; Connection error";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_delete.php'><button type='button'>Try again</button>";
			exit();
		}
		else
		{
			$sql2 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent','$query_date')");
			echo "SUCCESS: Account deactivated";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/login_customer.php'><button type='button'>Try again</button>";
			exit();
		}
	}
	else
	{
		$sql3 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent3','$query_date')");
		echo "ERROR: An error occured; Recaptcha error;";
		echo"<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/customer/customer_delete.php'><button type='button'>Try again</button></a>";
		exit();
	}
}
else
{
	$sql3 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent4','$query_date')");
	echo "ERROR: An error occured; Password incorrect";
	echo"<br>";
	echo"<br>";
	echo "<a href='http://localhost/CRUD/customer/customer_delete.php'><button type='button'>Try again</button>";
	exit();
}

?>
