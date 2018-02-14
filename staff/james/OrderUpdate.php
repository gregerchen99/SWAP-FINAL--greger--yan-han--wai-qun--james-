<?php
session_start();

$link = mysqli_connect("localhost", "root", "", "encryption");
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 

$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
	if ($user == "HR DEPARTMENT")
	{
		  echo "No entry";
   		 header("Refresh:0; http://localhost/CRUD/");
    	session_unset();
    	session_destroy();
    	exit();
	}
	elseif ($user == "AUDITOR")
	{
		 echo "No entry";
   		 header("Refresh:0; http://localhost/CRUD/");
    	session_unset();
    	session_destroy();
    	exit();
	}
	$u = "SELECT * FROM `employee_info` WHERE `employee_name` = '$user'";
  $valid = $link->query($u);
  if($valid->num_rows > 0)
  {

  }
  else
  {
    echo "No entry";
    header("Refresh:0; http://localhost/CRUD/");
    session_unset();
    session_destroy();
    exit();
}
} else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

$OrderID = mysqli_real_escape_string($link, $_REQUEST['OrderID']);
$NewOrderStatus = mysqli_real_escape_string($link, $_REQUEST['NewOrderStatus']);
//Logs
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Order successfully updated";
$logevent2 = "Staff: Order failed to update; Connection error";
$logevent3 = "Staff: Order failed to update; Invalid order id";

$sql = "UPDATE `order_info` SET `order_status`='$NewOrderStatus' WHERE `order_id`='$OrderID'";

$sql1 = "SELECT * FROM `order_info` WHERE `order_id` = '$OrderID'";

$result = $link->query($sql1);

if($result->num_rows > 0)//check if the order id entered is used. 
{
	if(mysqli_query($link, $sql))
	{
		$sql2 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent', '$query_date')");
		echo "SUCCESS: Order successfully updated.";
		echo"<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
		exit();
	}
	else
	{
		$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2', '$query_date')");
		echo "ERROR: Connection error.";
		echo"<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/staff/james/OrderUpdate.html'><button type='button'>Back</button></a>";
		exit();
	}
} 
else
{
	$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3', '$query_date')");
    echo "ERROR: Invalid order ID";
    echo "<br>";
    echo "<br>";
    echo "<a href='http://localhost/CRUD/staff/james/OrderUpdate.html'><button type='button'>Back</button></a>";
    exit();
}
?>