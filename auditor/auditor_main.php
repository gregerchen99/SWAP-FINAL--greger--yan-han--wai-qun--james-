<?php
session_start();
include('session.php');
$con = mysqli_connect("localhost","root","","encryption");
if (!$con)
{
	die('Could not connect: '. mysqli_connect_errno()); //return error if connect fails
}

$user = "-1";
if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
  if($user == "AUDITOR")
  {

  }
  else
  {
    echo "No access";
    header("Refresh:0; http://localhost/CRUD/");
    session_unset();
    session_destroy();
    exit();
  }
} else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

echo "You are signed in as ". $user . ".<br>";
?>
<html>
<!DOCTYPE html>
<html>
<body>
	<form action="http://localhost/CRUD/login_staff.php" method="post">
	<a href="http://localhost/CRUD/auditor/comment.php"><input type="button"  value="Add log comment"/>
	<br>
	<input type="Submit" name="cmdlogout" value="Logout">
	<br>
   </a>
	</form>
</body>
</html>

<?php
echo "Employee Log Details";
$sql = mysqli_query($con, "SELECT * FROM `log_info`");

echo "<table border='1'>
<tr>
<th>Log Id</th>
<th>Log User</th>
<th>Log Event</th>
<th>Log time</th>
<th>Log comment</th>
</tr>";

while ($row = mysqli_fetch_array($sql))
{
  echo "<tr>";
  echo "<td>" . $row['log_id'] . "</td>";
  echo "<td>" . $row['log_user'] . "</td>";
  echo "<td>" . $row['log_event'] . "</td>";
  echo "<td>" . $row['log_time'] . "</td>";
  echo "<td>" . $row['log_comment'] . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "<br>";

echo "Customer Log Details";
$sql1 = mysqli_query($con, "SELECT * FROM `custlog_info`");

echo "<table border='1'>
<tr>
<th>Log Id</th>
<th>Log User</th>
<th>Log Event</th>
<th>Log time</th>
<th>Log comment</th>
</tr>";

while ($row = mysqli_fetch_array($sql1))
{
  echo "<tr>";
  echo "<td>" . $row['custlog_id'] . "</td>";
  echo "<td>" . $row['custlog_user'] . "</td>";
  echo "<td>" . $row['custlog_event'] . "</td>";
  echo "<td>" . $row['custlog_time'] . "</td>";
  echo "<td>" . $row['custlog_comment'] . "</td>";
  echo "</tr>";
}

?>


