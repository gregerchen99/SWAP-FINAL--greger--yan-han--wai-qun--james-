<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "encryption"); //connect to database
 
// Check connection
if($link === false){
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
 
$bookname = mysqli_real_escape_string($link, $_REQUEST['Book_name']);
$bookauthor = mysqli_real_escape_string($link, $_REQUEST['Book_author']);
$bookprice = mysqli_real_escape_string($link, $_REQUEST['Book_price']);
$bookgenre = mysqli_real_escape_string($link, $_REQUEST['Book_genre']);
//Logs
$query_errors = 0;
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Book failed to add; Connection failed";
$logevent2 = "Staff: Book added successfully; ";

$sql = "INSERT INTO `book_info`(`book_name`, `book_author`, `book_price`, `book_genre`) VALUES ('$bookname', '$bookauthor', '$bookprice', '$bookgenre')";
$sql1 = "SELECT * FROM `book_info` WHERE `book_name`='$bookname'";

$result = $link->query($sql1);

if($result->num_rows > 0)
{
	$sql2 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent','$query_date')");
	echo "ERROR: Book Title in used";
	echo "<br>";
	echo "<br>";
	echo "<a href='http://localhost/CRUD/staff/wai%20qun/create1.html'><button type='button'>Back</button></a>";
}
else
{
	if (mysqli_query($link, $sql))
	{
		$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
		echo "SUCCESS: Book added into database";
		echo "<br>";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
	} 
	else
	{
		$sql2 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent','$query_date')");
		echo "ERROR: Connection failed";
		echo "<br>";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/staff/wai%20qun/create1.html'><button type='button'>Back</button></a>";
	}
} 

mysqli_close($link);// close connection
?>
