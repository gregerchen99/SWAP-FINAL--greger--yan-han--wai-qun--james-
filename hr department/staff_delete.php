<?php
session_start();

$con = mysqli_connect("localhost","root","","encryption"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fai(l
}

$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
	if($user == "HR DEPARTMENT")
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


$UID = mysqli_real_escape_string($con, $_REQUEST["UID"]);
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent =  "HR: Successful deactivated account";
$logevent2 = "HR: Deactivate failed";


$sql = "DELETE FROM `employee_info` WHERE `employee_id` = '$UID' ";

$sql1 = "SELECT * FROM `employee_info` WHERE `employee_id` = '$UID' ";

$result = $con->query($sql1);


if($result->num_rows > 0)
{
	if($UID == 1 || $UID == 2)
	{
		$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
		echo "ERROR: Cannot delete system accounts";
		echo "<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/hr%20department/staff_delete.html'><button type='button'>Back</button></a>";
		exit();
	}
	else
	{	
		if(mysqli_query($con, $sql))
		{
			$sql2 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent','$query_date')");
    		echo "SUCCESS: Account deleted.";
    		echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/hr%20department/admin_main.php'><button type='button'>Back to main</button></a>";
			exit();
		}
		else
		{
			$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
 			echo "ERROR: Connection failed";
 			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/hr%20department/staff_delete.html'><button type='button'>Back</button></a>";
			exit();
		}
	}
}
else
{
	$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
	echo "ERROR: No user to delete";
 	echo"<br>";
	echo"<br>";
	echo "<a href='http://localhost/CRUD/hr%20department/staff_delete.html'><button type='button'>Back</button></a>";
	exit();
}


