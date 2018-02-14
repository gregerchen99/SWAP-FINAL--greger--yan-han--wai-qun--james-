<!DOCTYPE html>
<html>

<?php
session_start();
$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
} else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

?>
<h1> CHANGE YOUR PASSWORD </h1>
<?php




$success = "";
$link = mysqli_connect("localhost", "root", "", "encryption");
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
$options = ['cost' => 12];
$creationdate = date("Y-m-d");
echo $creationdate;




if(isset($_POST['Password1'] , $_POST['Password2'])){

	$Password1 = mysqli_real_escape_string($link, $_POST['Password1']);
	$Password2 = mysqli_real_escape_string($link, $_POST['Password2']);
	

	if($Password1 == $Password2 ){
		$hash = password_hash($Password1, PASSWORD_BCRYPT, $options);
		$sql = "UPDATE customer_info SET cust_pw = '$hash' WHERE cust_name = '$user'"; 
		$result = mysqli_query($link,$sql);

		if(mysqli_query($link,$sql)){
			$success=1;
			session_unset();
			session_destroy();

		} else{
			echo "Please try again";
		}

	} else {
		$error_message = "Password do not match!";
		
	}
	
} else {
	echo "Please key in your new password";

}

?>

	<?php
		if(!empty($error_message)) {
	?>

	<div> <?php echo $error_message; ?> </div>

	<?php
		}
	?>


<body>
<?php
	if($success == 1){

			header("Refresh:3; http://localhost/CRUD/login_customer.php");
			echo "Password successfully reseted.";
			echo "<br>";
			echo "Please login with your new Password";
			$sql3 = mysqli_query($link, "UPDATE password_expiry SET last_update = '$creationdate' WHERE username = '$user'");

	} else {

?>

	
	<form action="reset_password_page.php" method="post">
	<label for="Enter new password">Enter new password :</label>
	<input type="password" name="Password1" id="Password1" placeholder="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters">
	<label for="Password">Enter password again:</label>
	<input type="password" name="Password2" id="Password2" placeholder="confirm password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must be 8 characters including 1 uppercase letter, 1 lowercase letter and numeric characters">
	<input type="Submit" value="Submit">
	</form>
	<br>

<?php
	}
?>	
</body>
</html>
