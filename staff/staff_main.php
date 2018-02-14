<?php
session_start();
include('session.php');

$con = mysqli_connect("localhost","root","","encryption");
if (!$con)
{
	die('Could not connect: '. mysqli_connect_errno()); //return error if connect fails
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
  elseif ($user == "AUDITOR") {
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

echo "You are signed in as ". $user . ".<br>";
?>
<!DOCTYPE html>
<html>
<body>
	<form action= "http://localhost/CRUD/login_staff.php" method="post">
	<input type="Submit" name="cmdlogout" value="Logout">
	</form>
</body>
</html>

<?php
echo "Account Details";
$sql = mysqli_query($con, "SELECT `employee_id`, `employee_name`, `employee_hp`, `employee_email`, `employee_address`, `employee_postal_code`, `employee_joined_date`, `employee_salary`, `employee_role` FROM `employee_info` WHERE `employee_name` = '$user'");

echo "<table border='1'>
<tr>
<th>employee_id</th>
<th>employee_name</th>
<th>employee_hp</th>
<th>employee_email</th>
<th>employee_address</th>
<th>employee_postal_code</th>
<th>employee_joined_date</th>
<th>employee_salary</th>
<th>employee_role</th>
</tr>";

while ($row = mysqli_fetch_array($sql))
{
  echo "<tr>";
  echo "<td>" . $row['employee_id'] . "</td>";
  echo "<td>" . $row['employee_name'] . "</td>";
  echo "<td>" . $row['employee_hp'] . "</td>";
  echo "<td>" . $row['employee_email'] . "</td>";
  echo "<td>" . $row['employee_address'] . "</td>";
  echo "<td>" . $row['employee_postal_code'] . "</td>";
  echo "<td>" . $row['employee_joined_date'] . "</td>";
  echo "<td>" . $row['employee_salary'] . "</td>";
  echo "<td>" . $row['employee_role'] . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "<br>";
?>
<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/CRUD/staff/employee/staff_update.html">
  <input type="button" value="Update details" style="text-align: center">
  </a>
</body>
</html>

<?php
echo "<br>";
echo "<br>";
echo "Product Details";
$sql1 = mysqli_query($con, "SELECT `book_id`, `book_name`, `book_author`, `book_price`, `book_genre` FROM `book_info`");

echo "<table border='1'>
<tr>
<th>book_id</th>
<th>book_name</th>
<th>book_author</th>
<th>book_price</th>
<th>book_genre</th>
</tr>";

while ($row = mysqli_fetch_array($sql1))
{
  echo "<tr>";
  echo "<td>" . $row['book_id'] . "</td>";
  echo "<td>" . $row['book_name'] . "</td>";
  echo "<td>" . $row['book_author'] . "</td>";
  echo "<td>" . $row['book_price'] . "</td>";
  echo "<td>" . $row['book_genre'] . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "<br>";
?>
<!DOCTYPE html>
<html>
<body>
  <a href="http://localhost/CRUD/staff/wai%20qun/create1.html">
  <input type="button" value="Create new product" style="text-align: center">

  <a href="http://localhost/CRUD/staff/wai%20qun/update1.html">
  <input type="button" value="Update product" style="text-align: center">

  <a href="http://localhost/CRUD/staff/wai%20qun/Delete_data1.html">
  <input type="button" value="Delete product" style="text-align: center">
  </a>
</body>
</html>

<?php
echo "<br>";
echo "<br>";


$sql2 = mysqli_query($con, "SELECT * FROM `order_info`");

echo "<table border='1'>
<tr>
<th>order_id</th>
<th>cust_id</th>
<th>book_id</th>
<th>order_date</th>
<th>total_price</th>
<th>order_status</th>
</tr>";

while ($row = mysqli_fetch_array($sql2))
{
  echo "<tr>";
  echo "<td>" . $row['order_id'] . "</td>";
  echo "<td>" . $row['cust_id'] . "</td>";
  echo "<td>" . $row['book_id'] . "</td>";
  echo "<td>" . $row['order_date'] . "</td>";
  echo "<td>" . $row['total_price'] . "</td>";
  echo "<td>" . $row['order_status'] . "</td>";
  echo "</tr>";
}
echo "</table>";
echo "<br>";

?>
<!DOCTYPE html>
<html>
<body>
	<a href="http://localhost/CRUD/staff/james/OrderCreate.html">
	<input type="Submit" value="Create new order" style="text-align: center">

	<a href="http://localhost/CRUD/staff/james/OrderUpdate.html">
	<input type="Submit" value="Update order" style="text-align: center">

	<a href="http://localhost/CRUD/staff/james/OrderDelete.html">
	<input type="Submit" value="Delete order" style="text-align: center">
  </a>
</body>
</html>