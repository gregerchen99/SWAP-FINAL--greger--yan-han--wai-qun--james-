<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "encryption");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
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


 
// Escape user inputs for security
$OrderID = mysqli_real_escape_string($link, $_REQUEST['OrderID']);
//Logs
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Order successfully deleted";
$logevent2 = "Staff: Order failed to delete; Connection error";
$logevent3 = "Staff: Order failed to delete; Invalid order id";


 
// attempt insert query execution
$sql = "DELETE FROM `order_info` WHERE `order_id`='$OrderID'";
$sql1 = "SELECT * FROM `order_info` WHERE `order_id`='$OrderID'";//check if the order id is used

$result = $link->query($sql1);


if($result->num_rows > 0)
{
    if(mysqli_query($link, $sql))
    {
    	$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent', '$query_date')");
        echo "SUCCESS: Order deleted successfully.";
        echo "<br>";
        echo "<br>";
        echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
        exit();
    }
    else
    {
        $sql4 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2', '$query_date')");
        echo "ERROR: Connection error.";
        echo "<br>";
        echo "<br>";
        echo "<a href='http://localhost/CRUD/staff/james/OrderDelete.html'><button type='button'>Back</button></a>";
        exit();
    }

} 
else
{
    $sql4 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3', '$query_date')");
    echo "ERROR: Invalid order ID.";
    echo "<br>";
    echo "<br>";
    echo "<a href='http://localhost/CRUD/staff/james/OrderDelete.html'><button type='button'>Back</button></a>";
    exit();
}
?>