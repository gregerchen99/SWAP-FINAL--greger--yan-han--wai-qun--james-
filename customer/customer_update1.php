<?php 
session_start();
$con = mysqli_connect("localhost","root","","encryption");

if (!$con)
{
	die('Could not connect: '. mysqli_connect_errno()); //return error if connect fails
}
//Session variables
$user = "-1";
if(isset($_SESSION["user"])){
	$user = $_SESSION["user"];
	$u = "SELECT * FROM `customer_info` WHERE `cust_name` = '$user'";
	$valid = $con->query($u);
	if($valid->num_rows > 0)
	{

	}
	else
	{
		 header("Refresh:0; http://localhost/CRUD/");
    	 session_unset();
    	session_destroy();
    	exit();
	}
} else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

//Form variables
$Username = mysqli_real_escape_string($con, $_REQUEST['Username']);
$Email = mysqli_real_escape_string($con, $_REQUEST['Email']);
$Password = mysqli_real_escape_string($con, $_REQUEST['Password']);
$Contact = mysqli_real_escape_string($con, $_REQUEST['Contact']);
$Address = mysqli_real_escape_string($con, $_REQUEST['Address']);
$Postalcode = mysqli_real_escape_string($con, $_REQUEST['Postalcode']);
$options = ['cost' => 12];
$hash = password_hash($Password, PASSWORD_BCRYPT, $options);
//Logging variables
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent =  "Customer: Update successful";
$logevent2 = "Customer: Update failed; Connection error";
$logevent3 = "Customer: Update failed; Email in used";
$logevent4 = "Customer: Update failed; Username in used";
//encryption
$key = "potato1234potato";
$initVector = "potato1234potato";
$encryptNum = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $Contact, MCRYPT_MODE_CFB, $initVector);
//Recaptcha variables
$creationdate = date("Y-m-d");

if (!isset($Address) || empty($Address))
{

        //$address_url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=1.32824,103.9516529&key=AIzaSyAwQShuj9NkSNVP_-lmIqL9ZCq5-5ImGXQ';
        exit();
}

$geodata = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($Address).'&key=AIzaSyAwQShuj9NkSNVP_-lmIqL9ZCq5-5ImGXQ'));
if(!$geodata) 
{
  echo("Error to extract geodata.");
  exit();
}

$status = $geodata->status;
//echo $status;

if ($status == "ZERO_RESULTS")
{
	echo "The address does not match the postal code";
	echo "<br>";
	echo "<br>";
	echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Back</button></a>";
	exit();
}
elseif ($status == "OK")
{

$lat  = $geodata->results[0]->geometry->location->lat; 
$lng = $geodata->results[0]->geometry->location->lng;

$geodata = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&key=AIzaSyAwQShuj9NkSNVP_-lmIqL9ZCq5-5ImGXQ')); 

foreach($geodata->results[0]->address_components as $addAttr)
{
    if($addAttr->types[0] == 'postal_code')
    {
        if(empty($addAttr->long_name) || !isset($addAttr->long_name)) 
        {
            throw new exception("Postal Code not found, Please try to input different address.");
        }
        else
        {
    		//echo $addAttr->long_name;
 		}
    } 
}
$webpostal = $addAttr->long_name;
$chances = similar_text($webpostal, $Postalcode, $perc);
//echo $perc;
//echo $addAttr->long_name;

if ($addAttr->long_name === $Postalcode)
{

}
elseif($perc > '80.3')
{
	
}
else
{
	//echo $addAttr->long_name;
	//echo "hi";
	echo "The address does not match the postal code";
	echo "<br>";
	echo "<br>";
	echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Back</button></a>";
	exit();
}
}

$sql = "UPDATE `customer_info` SET `cust_name` = '$Username', `cust_email` = '$Email', `cust_pw` = '$hash', `cust_hp` = '$encryptNum', `Address` = '$Address', `Postalcode` = '$Postalcode' WHERE `cust_name` = '$user'";
$sql1 = "SELECT * FROM `customer_info` WHERE `cust_name` = '$Username'";//check if the new username is used. 
$result1 = $con->query($sql1); 
$sql5 = "SELECT * FROM `customer_info` WHERE `cust_email` = '$Email'";//check if the new email is used
$result2 = $con->query($sql5);
$sql6 = mysqli_query($con, "SELECT `cust_email` FROM `customer_info` WHERE `cust_name` = '$user'");
$sql7 = mysqli_query($con, "SELECT `cust_name` FROM `customer_info` WHERE `cust_name` = '$user'");

while ($row = $sql6->fetch_assoc()) 
{
	$dbemail = $row['cust_email'];
}

while ($row = $sql7->fetch_assoc()) 
{
	$dbname = $row['cust_name'];
}


if($Username == $dbname)//if username set = username stored in database
{
	if($Email == $dbemail)
	{
		if(mysqli_query($con,$sql))//if email and username entered matchs database record, and connection is valid
		{
			$sql2 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent','$query_date')");
			//INSERT INTO LOG WITH NEWLY SET CREDENTIALS
			$sql3 = mysqli_query($con, "UPDATE `custlog_info` SET `custlog_user` = '$Username' WHERE `custlog_user` = '$user'");
			//UPDATE OLD LOGS WITH NEW CREDENTIALS
			$passquery = mysqli_query($con, "UPDATE password_expiry SET username = '$Username', last_update = '$creationdate' WHERE username = '$user'");
			echo "SUCCESS: Update successful.";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_main.php'><button type='button'>Return to main</button></a>";
			exit();
		}
		else//if email and username entered matches database record, but connection is invalid
		{
			$sql4 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent2','$query_date')");
			echo "ERROR: Update failed; Connnection error";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Try again</button></a>";
			exit();
		}
	}
	else//if username matches but email is different
	{
		if($result2->num_rows > 0)//checks if email is used
		{
			$sql4 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent3','$query_date')");
			echo "ERROR: Update failed; Email is already in used";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Try again</button></a>";
			exit();
		}
		else
		{
			if(mysqli_query($con, $sql))//if email is different and not in used, 
			{
				$sql2 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent','$query_date')");
				//INSERT INTO LOG WITH NEWLY SET CREDENTIALS
				$sql3 = mysqli_query($con, "UPDATE `custlog_info` SET `custlog_user` = '$Username' WHERE `custlog_user` = '$user'");
				$passquery = mysqli_query($con, "UPDATE password_expiry SET username = '$Username', last_update = '$creationdate' WHERE username = '$user'");
				echo "SUCCESS: Update successful.";
				echo"<br>";
				echo"<br>";
				echo "<a href='http://localhost/CRUD/customer/customer_main.php'><button type='button'>Return to main</button></a>";
				exit();
			}
			else
			{
				$sql4 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent2','$query_date')");
				echo "ERROR: Update failed; Connection error";
				echo"<br>";
				echo"<br>";
				echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Try again</button></a>";
				exit();	
			}
		}
	}
}
else
{
	if($result1->num_rows > 0)//username is in used
	{
		$sql4 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent4','$query_date')");
		echo "ERROR: Update failed; Username is already in used";
		echo"<br>";
		echo"<br>";
		echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Try again</button></a>";
		exit();
	}
	else
	{
		if(mysqli_query($con, $sql))
		{
			$sql2 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent','$query_date')");
			//INSERT INTO LOG WITH NEWLY SET CREDENTIALS
			$sql3 = mysqli_query($con, "UPDATE `custlog_info` SET `custlog_user` = '$Username' WHERE `custlog_user` = '$user'");
			$passquery = mysqli_query($con, "UPDATE password_expiry SET username = '$Username', last_update = '$creationdate' WHERE username = '$user'");
			echo "SUCCESS: Update successful. Log out to see changes";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/login_customer.php'><button type='button'>Log out</button></a>";
			exit();
		}
		else
		{
			$sql4 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$user', '$logevent2','$query_date')");
			echo "ERROR: Update failed; Connection error";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_update.php'><button type='button'>Try again</button></a>";
			exit();	
		}
	}
}











