<html>
<h2>Staff Login </h2>


<?php
session_start();

		if (isset($_POST['cmdlogout'])) {	
		
		
		
		
		
		
		$con = mysqli_connect("localhost","root","","encryption");
		date_default_timezone_set('Singapore');
		$query_date = date('Y-m-d H:i:s');
		$sql_errors = 0;
	     $loguser = $_SESSION["user"];
		$mylogevent = "$loguser has logged out.";
		$sq = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$loguser', '$mylogevent', '$query_date')");	
		if (mysqli_query($con, $sq)) {}
		
		session_unset();
		 } 

$success = "";
$error_message = "";
$con = mysqli_connect("localhost","root","","encryption");
if(!$con)
{
	die('Could not connect: '.mysqli_connect_errno());
}
date_default_timezone_set('Singapore');
$starttime = "09:00:00";
$endtime = "18:30:00";
$currenttime = date('H:i:s');
$query_errors = 0;
$query_date = date('Y-m-d H:i:s');
$logevent = "Staff: Login attempt failed";
$logevent2 = "Staff: Successful login";
$logevent3 = "Staff: Access outside of restricted hours";
$logevent4 = "HR: Login attempt failed";
$logevent5 = "HR: Successful login";
$logevent6 = "HR: Access outside of restricted hours";
$logevent7 = "AUDITOR: Successful login";
$logevent8 = "AUDITOR: Access outside of restricted hours";
$logevent9 = "Invalid OTP entered";
$logevent10 = "AUDITOR: Login attempt failed";

if(isset($_POST['Username'], $_POST['Password'])){
	
	$Username = mysqli_real_escape_string($con , $_POST['Username']);
	$Password = mysqli_real_escape_string($con , $_POST['Password']);
	//sessions?


	$sql = mysqli_query($con, "SELECT `employee_pw` FROM `employee_info` WHERE `employee_name` = '$Username'");
	$sql2= mysqli_query($con, "SELECT `employee_email` FROM `employee_info` WHERE `employee_name` = '$Username'");
	//$query = mysqli_query($con, "SELECT `employee_name` FROM `employee_info` WHERE `employee_name` = '$Username'");
	$query = mysqli_query($con, "SELECT * FROM `employee_info` WHERE `employee_name` = '$Username'");
	//$number = $con->query($query);
	$query1 = "SELECT * FROM `employee_info` WHERE `employee_name` = '$Username'";
	$number = $con->query($query1);

	if($number->num_rows > 0)
	{

	}
	else
	{
		echo "Username or Password incorrect";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
		exit();
	}

	while ($row = $query->fetch_assoc())
	{
		$name = $row['employee_name'];
	}

	if($name == $Username)
	{

	}
	else
	{
		echo "Username or Password incorrect";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
		exit();
	}


	while ($row = $sql2->fetch_assoc()) {
		$email =  $row['employee_email'];
	}

	//while($row = mysqli_fetch_array($sql))
	//{
	//	$hash = $row['employee_pw'];
	//}



	if ($row = mysqli_fetch_assoc($sql)) {
	$hashedPwcheck = password_verify($Password, $row['employee_pw']);
	{
		if ($hashedPwcheck == true){
		
		
		
		$_SESSION["user"] = $Username;
		
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		require_once("phpmailerr.php");
		$mail_status = sendOTP($email,$otp);
		}
		else
		{
			echo "Username or Password incorrect";
			echo "<br>";
			echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
			exit();
		}
		
		
		
		
		if($mail_status == 1) {
				$expireold = mysqli_query($con,"UPDATE otp_expiry SET is_expired = 1 WHERE employee_email = '" . $email . "'");
				$result = mysqli_query($con,"INSERT INTO otp_expiry(otp,is_expired,create_at,employee_email) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "', '". $email ."')");
				$current_id = mysqli_insert_id($con);
				if(!empty($current_id)) {
				
					$success=1;
					
				
				
				}
			}
	
	elseif ($hashedPwcheck == false){
		$norep = 0;
			if ($norep == 0){
				$sql = "INSERT INTO log_info (log_user, log_event, log_time )VALUES ('$Username', '$logevent', '$query_date');";  
				$result = mysqli_query($con,$sql);
			$norep++;}
		echo "Username or Password incorrect";
			
	
	}
	}
				
} 
}

if(isset($_POST["submit_otp"])) {
				$submitOTP = mysqli_real_escape_string($con , $_POST["submit_otp"]);
				if(isset($_SESSION["user"])){
						$Username = $_SESSION["user"];
						$sql2= mysqli_query($con, "SELECT `employee_email` FROM `employee_info` WHERE `employee_name` = '$Username'");
						while ($row = $sql2->fetch_assoc()) {
							$email =  $row['employee_email'];
						}
						
						$result = mysqli_query($con,"SELECT * FROM otp_expiry WHERE otp= '$submitOTP' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 5 MINUTE) AND employee_email= '$email'");
						$count  = mysqli_num_rows($result);
						if(!empty($count)) {
							$result = mysqli_query($con,"UPDATE otp_expiry SET is_expired = 1 WHERE otp = '" . $submitOTP . "'");
							$success = 2;	
						} else {
							$success =1;
							$error_message = "Invalid OTP!";
							//Logging invalid otp entered
							$sq90 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent9', '$query_date')");
						}
					}
						
				}	


?>

<body>
	<?php
		if(!empty($error_message)) {
	?>
	<div><?php echo $error_message; ?></div>
	<?php
		}
	?>
	

	
	
	<form action="login_staff.php" method="post">
		<?php 
			if(!empty($success == 1)) { 
		?>
		<label for="submit_otp">Enter OTP</label>
		<input type="text" name="submit_otp" id="submit_otp" placeholder="submit otp" required>
		<input type="Submit" value="Submit">
		<a href="http://localhost/CRUD/login_staff.php"><input type="button"  value="Back"/>
		
		<?php
			
			} else if ($success == 2) {
			
					if($Username == "HR DEPARTMENT")
					{
						if($currenttime > $starttime && $currenttime < $endtime)
						{
							$sql20 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent5', '$query_date')");
							header("Refresh:5; http://localhost/CRUD/hr%20department/admin_main.php");//to change
							echo "Welcome HR DEPARTMENT ... Loading your account..";//to change
						}
						else
						{
							$sql30 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent6', '$query_date')");
							echo "Access denied! Aceess outside of restricted hours.";
							echo"<br>";
							echo"<br>";
							echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
						}
					}
					elseif ($Username == "AUDITOR") 
					{
						if($currenttime > $starttime && $currenttime < $endtime)
						{
							//Add this to log table
							$sql20 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent7', '$query_date')");
							//Redirect page to auditor main
							header("Refresh:5; http://localhost/CRUD/auditor/auditor_main.php");
							echo "Welcome AUDITOR... Loading your account..";
						}
						else
						{
						$sql30 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent8', '$query_date')");
						//Redirect page back to login
						echo "Access denied! Aceess outside of restricted hours.";
						echo"<br>";
						echo"<br>";
						echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
						}
					}
					else
					{
						$query = "SELECT * FROM `employee_info` WHERE `employee_name` = '$Username'";
						$result = $con->query($query);
						
							if($currenttime > $starttime && $currenttime < $endtime)
							{
							$sql20 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Username', '$logevent2', '$query_date')");
							header("Refresh:5; http://localhost/CRUD/staff/staff_main.php");
							echo "Welcome ". $Username. "... Loading your account..";
							}
							else
							{
							$sql30 = mysqli_query($con, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('$Email1', '$logevent3', '$query_date')");
							echo "Access denied! Aceess outside of restricted hours.";
							echo"<br>";
							echo"<br>";
							echo "<a href='http://localhost/CRUD/login_staff.php'><button type='button'>Back to login</button>";
							}
											
					} 
				
		}else {
		?>
		
		<label for="Username">Username:</label>
		<input type="text" name="Username" id="Username" placeholder="Username" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Username must begin with a character">
		<label for="Password">Password:</label>
		<input type="password" name="Password" id="Password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters">
		<input type="Submit" value="Login">
		<br>
		<?php
		}
		?>
	</form>
</body>
</html>
