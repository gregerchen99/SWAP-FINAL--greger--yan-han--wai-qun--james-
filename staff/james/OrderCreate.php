<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "encryption");
 
if($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
  if($user == "HR DEPARTMENT")
  {
    echo "No entry";
    header("Refresh:0; http://localhost/CRUD/");
    session_unset();
    session_destroy();
    exit();
  }
  elseif($user == "AUDITOR")
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
 
$CustomerID = mysqli_real_escape_string($link, $_REQUEST['CustomerID']);
$Product = mysqli_real_escape_string($link, $_REQUEST['Product']);
$OrderDate = mysqli_real_escape_string($link, $_REQUEST['OrderDate']);
$TotalPrice = mysqli_real_escape_string($link, $_REQUEST['TotalPrice']);
$OrderStatus = mysqli_real_escape_string($link, $_REQUEST['OrderStatus']);
//Logs
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Order successfully created";
$logevent2 = "Staff: Order failed to create; Connection error";
$logevent3 = "Staff: Order failed to create; Invalid book id";
$logevent4 = "Staff: Order failed to create; Invalid customer id";
//$logevent3 = "Order; Invalid customer_id";
 
// attempt insert query execution
$sql = "INSERT INTO `order_info` (`cust_id`, `book_id`, `order_date`, `total_price`, `order_status`) VALUES ('$CustomerID', '$Product', '$OrderDate', '$TotalPrice', '$OrderStatus')";
$sql1 = "SELECT * FROM `customer_info` WHERE `cust_id` = '$CustomerID'";
$sql2 = "SELECT * FROM `book_info` WHERE `book_id` = '$Product'";

$result = $link->query($sql1);
$result1 = $link->query($sql2);


if($result->num_rows > 0)//Customer id is used. There is a existing customer
{
	if($result1->num_rows > 0)//book id is used. There is a existing book. 
  {
        if(mysqli_query($link, $sql))
	      { 
          $sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent','$query_date')");
    	    echo "SUCCESS: Order created";
          echo "<br>";
          echo "<br>";
          echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
          exit();
        }
        else
        {
    	     $sql4 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
           echo "ERROR: Connection error";
           echo "<br>";
           echo "<br>";
           echo "<a href='http://localhost/CRUD/staff/james/OrderCreate.html'><button type='button'>Back</button></a>";
           exit();
        }
  }
  else
  {
        $sql4 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3', '$query_date')");
        echo "ERROR: Invalid book ID";
        echo "<br>";
        echo "<br>";
        echo "<a href='http://localhost/CRUD/staff/james/OrderCreate.html'><button type='button'>Back</button></a>";
  }
}    
else
{
    $sql5 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3', '$query_date')");
    echo "ERROR: Invalid customer ID";
    echo "<br>";
    echo "<br>";
    echo "<a href='http://localhost/CRUD/staff/james/OrderCreate.html'><button type='button'>Back</button></a>";
}
?>