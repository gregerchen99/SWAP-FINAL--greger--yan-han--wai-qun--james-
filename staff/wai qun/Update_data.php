<?php
session_start();
$con = mysqli_connect("localhost","root","","encryption"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno());
} //return error is connect fai(l

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
  $valid = $con->query($u);
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

$bookinput = mysqli_real_escape_string($con, $_POST["bookinput"]);
$bookname = mysqli_real_escape_string($con, $_POST['Book_name']);
$bookauthor = mysqli_real_escape_string($con, $_POST['Book_author']);
$bookprice = mysqli_real_escape_string($con, $_POST['Book_price']);
$bookgenre = mysqli_real_escape_string($con, $_POST['Book_genre']);
//Logs
$query_errors = 0;
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Book successfully updated";
$logevent2 = "Staff: Book failed to update; Connection error";
$logevent3 = "Staff: Book failed to update; Invalid book id ";
$logevent4 = "Staff: Book failed to update; Empty fields";

if ((!empty($bookname))&&(!empty($bookauthor))&&(!empty($bookprice))&&(!empty($bookgenre)))//If all fields is not empty. 
{
	$sql = "UPDATE `book_info` SET `book_name` = '$bookname', `book_author` = '$bookauthor', `book_price` = '$bookprice', `book_genre` = '$bookgenre' WHERE `book_id` = '$bookinput'";

	$sql1 = "SELECT * FROM `book_info` WHERE `book_id`=$bookinput";
	$result = $con->query($sql1);

	if (!empty($bookinput) && is_numeric($bookinput))//if input is not empty and is an integer
	{	
		if ($bookinput > 0) // if integer is greater than 0
		{	
			if ($result->num_rows > 0)
			{
				if(mysqli_query($con, $sql))
				{
					$sql2 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent','$query_date')");
					echo "SUCCESS: Book updated";
					echo "<br>";
					echo "<br>";
					echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
					exit();
				}
				else
				{
					$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2','$query_date')");
					echo "ERROR: Connection error";
					echo "<br>";
					echo "<br>";
					echo "<a href='http://localhost/CRUD/staff/wai%20qun/update1.html'><button type='button'>Back</button></a>";
					exit();
				}
			}
			else 
			{
				$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3','$query_date')");
				echo "ERROR: Invalid book ID";
				echo "<br>";
				echo "<br>";
				echo "<a href='http://localhost/CRUD/staff/wai%20qun/update1.html'><button type='button'>Back</button></a>";
				exit();
			}
		}
		else 
		{
			$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3','$query_date')");
			echo "ERROR: Invalid book ID";
			echo "<br>";
			echo "<br>";
			echo "<a href='http://localhost/CRUD/staff/wai%20qun/update1.html'><button type='button'>Back</button></a>";
			exit();
		}
	}
	else
	{
		$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3','$query_date')");
		echo "ERROR: Invalid book ID";
		echo "<br>";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/staff/wai%20qun/update1.html'><button type='button'>Back</button></a>";
		exit();
	}
}
else 
{
	$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent4','$query_date')");
	echo "ERROR: Empty Fields";
	echo"<br>";
	echo"<br>";
	echo "<a href='http://localhost/CRUD/staff/wai%20qun/update1.html'><button type='button'>Back</button></a>";
	exit();
}
?>