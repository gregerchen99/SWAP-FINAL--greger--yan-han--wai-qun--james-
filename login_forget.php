<html>
<h2>Change Password </h2>
		
<?php
	session_start();
	$success = "";
	$error_message = "";
	$con = mysqli_connect("localhost","root","","encryption");
	if(!$con)
	{
		die('Could not connect: '.mysqli_connect_errno());
	}
	date_default_timezone_set('Singapore');
		
		
	if(isset($_POST['Username'], $_POST['Email'])){
			
		$Username = mysqli_real_escape_string($con , $_POST['Username']);
		$Email = mysqli_real_escape_string($con , $_POST['Email']);
		$sql = mysqli_query($con, "SELECT * FROM `customer_info` WHERE `cust_name` = '$Username' AND `cust_email` = '$Email'");
		$count = mysqli_num_rows($sql);
		
		if(!empty($count)) { //Check if there is such user in the database
			$_SESSION["user1"] = $Username;
			$_SESSION["email"] = $Email;
			$otp = rand(100000,999999);
			require_once("phpmailerreset.php");
			$mail_status = sendOTP($Email,$otp);
			
			if($mail_status == 1) {
				$expireold = mysqli_query($con,"UPDATE otp_resetpw SET is_expired = 1 WHERE cust_email = '" . $Email . "'");
				$result = mysqli_query($con,"INSERT INTO otp_resetpw(otp,is_expired,create_at,cust_email) VALUES ('" . $otp . "', 0, '" . date("Y-m-d H:i:s"). "', '". $Email ."')");
				$current_id = mysqli_insert_id($con);
				if(!empty($current_id)) {
					$success=1;
				}
			}
				
		} else {
			echo "Invalid Email or Username!";
		}
	} 
		

	if(isset($_POST["submit_otp"])) {
		$submitOTP = mysqli_real_escape_string($con , $_POST["submit_otp"]);
		if(isset($_SESSION["user1"], $_SESSION["email"])){
			$Username = $_SESSION["user1"];
			$Email = $_SESSION["email"];
			$result = mysqli_query($con,"SELECT * FROM otp_resetpw WHERE otp= '$submitOTP' AND is_expired!=1 AND NOW() <= DATE_ADD(create_at, INTERVAL 5 MINUTE) AND cust_email= '$Email'");
			$count  = mysqli_num_rows($result);
			if(!empty($count)) {
				$result = mysqli_query($con,"UPDATE otp_resetpw SET is_expired = 1 WHERE otp = '" . $submitOTP . "'");
				$_SESSION["user"] = $Username;
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

	<div> <?php echo $error_message; ?> </div>

	<?php
		}
	?>


	<form action="login_forget.php" method="post">
		<?php 
			if(!empty($success == 1)) { 
		?>
		
		<label for="submit_otp">Enter OTP to reset your Password</label>
		<input type="text" name="submit_otp" id="submit_otp" placeholder="submit otp" required>
		<input type="Submit" value="Submit">
		<a href="http://localhost/CRUD/login_staff.php"><input type="button"  value="Back to Login"/>
		
		<?php
		
			} else if ($success == 2) {
			header("Refresh:3; http://localhost/CRUD/reset_password_page.php");
			echo "Redirecting you to the Password Reset Page";
			} else {
				echo "Please key in your Details";
			
		?>
		
		<br>
		<label for="Username">Username:</label>
		<input type="text" name="Username" id="Username" placeholder="Username" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Username must begin with a character">
		<label for="Password">Email:</label>
		<input type="email" name="Email" id="Email" placeholder="Email"  title="Please enter a valid Email">
		<input type="Submit" value="Submit">
		<br>
		
		<?php
		}
		?>
	</form>
</body>
</html>