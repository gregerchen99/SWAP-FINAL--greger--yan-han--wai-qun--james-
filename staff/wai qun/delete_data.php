<?php
session_start();
$con = mysqli_connect("localhost","root","","encryption"); //connect to database
if (!$con){
	die('Could not connect: ' . mysqli_connect_errno()); //return error is connect fai(l
}

$user = "-1";
if(isset($_SESSION["user"]))
{
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
//Logs
$query_errors = 0;
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Book record deleted";
$logevent2 = "Staff: Book record failed to delete; Invalid book id";
$logevent3 = "Staff: Book record failed to delete; Connection error";
$logevent4 = "Staff: Book record failed to delete; Empty fields";


$sql = "DELETE FROM book_info WHERE book_id = $bookinput";
$sql1 = "SELECT * FROM book_info WHERE book_id = $bookinput";

$result = $con->query($sql1);

if (is_numeric($bookinput))//if input is a number
{
	if (!empty($bookinput)) //if imput is not blank
	{
		if ($result->num_rows > 0) //If there is a record in the table
		{
			if(mysqli_query($con, $sql))// if connection is successful
			{
				$sql2 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent', '$query_date')");
				echo "SUCCESS: Book successfully deleted";// delete the data
				echo "<br>";
				echo "<br>";
				echo "<a href='http://localhost/CRUD/staff/staff_main.php'><button type='button'>Back to main</button></a>";
				exit();
			} 
			else
			{
				$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent3', '$query_date')");
				echo "ERROR: Connection error";//echo connection unsuccessful
				echo "<br>";
				echo "<br>";
				echo "<a href='http://localhost/CRUD/staff/wai%20qun/Delete_data1.html'><button type='button'>Back</button></a>";
			}
		}
		else 
		{
			$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2', '$query_date')");
			echo "ERROR: Invalid book ID";//echo connection unsuccessful
			echo "<br>";
			echo "<br>";
			echo "<a href='http://localhost/CRUD/staff/wai%20qun/Delete_data1.html'><button type='button'>Back</button></a>";
		}
	} 
	else 
	{
		$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent4', '$query_date')");
		echo "ERROR: Invalid book ID";//echo connection unsuccessful
		echo "<br>";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/staff/wai%20qun/Delete_data1.html'><button type='button'>Back</button></a>";
	}
} 
else 
{
	$sql3 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$user', '$logevent2', '$query_date')");
	echo "ERROR: Invalid book ID";//echo connection unsuccessful
	echo "<br>";
	echo "<br>";
	echo "<a href='http://localhost/CRUD/staff/wai%20qun/Delete_data1.html'><button type='button'>Back</button></a>";
}

?>
