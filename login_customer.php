<html>
<h2>Customer Login</h2>
<?php
session_start();

if (isset($_POST['cmdlogout'])) {	
		
		
		$con = mysqli_connect("localhost","root","","encryption");
		date_default_timezone_set('Singapore');
		$query_date = date('Y-m-d H:i:s');
		$sql_errors = 0;
	     $loguser = $_SESSION["user"];
		$mylogevent = "$loguser has logged out.";
		$sq = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$loguser', '$mylogevent', '$query_date')");	
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
$endtime = "22:30:00";
$currenttime = date('H:i:s');
$query_errors = 0;
$query_date = date('Y-m-d H:i:s');
$logevent2 = "Customer: Successful login";
$logevent3 = "Customer: Login attempt failed; Access outside of restricted hours";
$logevent4 = "Customer: Login attempt failed; Incorrect username or password";


if(isset($_POST['Username'], $_POST['Password'])){
	
	$Username = mysqli_real_escape_string($con , $_POST['Username']);
	$Password = mysqli_real_escape_string($con , $_POST['Password']);
	//sessions?


	$sql = mysqli_query($con, "SELECT `cust_pw` FROM `customer_info` WHERE `cust_name` = '$Username'");
	$sql2= mysqli_query($con, "SELECT `cust_email` FROM `customer_info` WHERE `cust_name` = '$Username'");
	$query = "SELECT * FROM `customer_info` WHERE `cust_name` = '$Username'";
	$number = $con->query($query);

	if($number->num_rows > 0)
	{

	}
	else
	{
		echo "Username or Password incorrect";
		echo "<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/login_customer.php'><button type='button'>Back to login</button>";
		exit();
	}


	while ($row = $sql2->fetch_assoc()) {
		$email =  $row['cust_email'];
	}

	while($row = mysqli_fetch_array($sql))
	{
		$hash = $row['cust_pw'];
	}




	if(password_verify($Password, $hash))
	{
		$_SESSION["user"] = $Username;
		
		// generate OTP
		$otp = rand(100000,999999);
		// Send OTP
		require_once("phpmailerr.php");
		$mail_status = sendOTP($email,$otp);
		
		
		
		if($mail_status == 1) {
				$expireold = mysqli_query($con,"UPDATE custotp_expiry SET is_expired = 1 WHERE cust_email = '" . $email . "'");
				$result = mysqli_query($con,"INSERT INTO custotp_expiry(otp,is_expired,create_at,cust_email) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "', '". $email ."')");
				$current_id = mysqli_insert_id($con);
				if(!empty($current_id)) {
				
					$success=1;
					
				
				
				}
			}
	
		
	
	}else{
		$sql50 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$Username', '$logevent4', '$query_date')");
		echo "Username or Password incorrect";
	}
				
} 

if(isset($_POST["submit_otp"])) {
				$submitOTP = mysqli_real_escape_string($con , $_POST["submit_otp"]);
				if(isset($_SESSION["user"])){
						$Username = $_SESSION["user"];
						$sql2= mysqli_query($con, "SELECT `cust_email` FROM `customer_info` WHERE `cust_name` = '$Username'");
						while ($row = $sql2->fetch_assoc()) {
							$email =  $row['cust_email'];
						}
						
						$result = mysqli_query($con,"SELECT * FROM custotp_expiry WHERE otp= '$submitOTP' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 5 MINUTE) AND cust_email= '$email'");
						$count  = mysqli_num_rows($result);
						if(!empty($count)) {
							$result = mysqli_query($con,"UPDATE custotp_expiry SET is_expired = 1 WHERE otp = '" . $submitOTP . "'");
							$success = 2;	
						} else {
							$success =1;
							$error_message = "Invalid OTP!";
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
	

	
	
	<form action="login_customer.php" method="post">
		<?php 
			if(!empty($success == 1)) { 
		?>
		<label for="submit_otp">Enter OTP</label>
		<input type="text" name="submit_otp" id="submit_otp" placeholder="submit otp" required>
		<input type="Submit" value="Submit">
		<a href="http://localhost/CRUD/login_customer.php"><input type="button"  value="Back"/>
		
		<?php
			
			} else if ($success == 2) {

        		$creationdate = mysqli_query($con,"SELECT `last_update` FROM `password_expiry` WHERE `username`= '$Username'");

    			while ($row = $creationdate->fetch_assoc()) {
      			$creationdate1 =  $row['last_update'];
    			}

    			$currentdate = date("Y-m-d");
    			$diff = abs(strtotime($currentdate) - strtotime($creationdate1));
    			$years = floor($diff / (365*60*60*24));
    			$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    			$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    			if($days > '28'){
    			echo "<br>";
    			echo "Your password has expired. Going to password reset page.";
    			header("Refresh:5; http://localhost/CRUD/login_forget.php");
    			}elseif($months > '1'){
    			echo "<br>";
    			echo "Your password has expired. Going to password reset page.";
    			header("Refresh:5; http://localhost/CRUD/login_forget.php");
    			}elseif($years > '1'){
    			echo "<br>";
    			echo "Your password has expired. Going to password reset page.";
    			header("Refresh:5; http://localhost/CRUD/login_forget.php");
    	//header("Refresh:3; http://localhost/CRUD/reset_password_page.php");
				}elseif($currenttime > $starttime && $currenttime < $endtime)
				{
					$sql20 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$Username', '$logevent2', '$query_date')");
					header("Refresh:5; http://localhost/CRUD/customer/customer_main.php");//to change
					echo "Welcome ". $Username. "... Loading your account..";//to change
				}
				else
				{
					$sql30 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$Username', '$logevent3', '$query_date')");
					echo "Access denied! Aceess outside of restricted hours.";
					echo"<br>";
					echo"<br>";
					echo "<a href='http://localhost/CRUD/login_customer.php'><button type='button'>Back to login</button>";
				}
			
		}else {
		?>
		
		<label for="Username">Username:</label>
		<input type="text" name="Username" id="Username" placeholder="Username" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Username must begin with a character">
		<label for="Password">Password:</label>
		<input type="password" name="Password" id="Password" placeholder="Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters">
		<input type="Submit" value="Login">
		<br>
		<a href="http://localhost/CRUD/customer/customer_register.html">Register now</a>
		<br>
		<a href="http://localhost/CRUD/login_forget.php">Forget your password</a>
		<?php
		}
		?>
	</form>
</body>
</html>
