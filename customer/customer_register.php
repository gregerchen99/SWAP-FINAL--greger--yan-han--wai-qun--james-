<?php

$con = mysqli_connect("localhost","root","","encryption");
if (!$con)
{
	die('Could not connect: '. mysqli_connect_errno()); //return error if connect fails
}

$query = $con->prepare("INSERT INTO `customer_info` (`cust_name`, `cust_pw`, `cust_email`, `cust_hp`,`Address`,`Postalcode`) VALUES (?,?,?,?,?,?)");
//Form variables
$Username = $_POST['Username'];
$Email = $_POST['Email'];
$Password = $_POST['Password'];
$Number = $_POST['Contact'];
$Address = $_POST['Address'];
$Postalcode = $_POST['Postalcode'];
$creationdate = date("Y-m-d");
$options = ['cost' => 12];
$hash = password_hash($Password, PASSWORD_BCRYPT, $options);
//encryption
$key = "potato1234potato";
$initVector = "potato1234potato";
$encryptNum = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $Number, MCRYPT_MODE_CFB, $initVector);
//Recaptcha variables
$recaptcha_secret = "6LeoTEAUAAAAAGCvy9ckWncD99XglkvSrvXr5vm_";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
$response = json_decode($response, true);
//Logging variables
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent =  "Customer: Successful created account";

$query->bind_param('sssssi', $Username, $hash, $Email, $encryptNum, $Address, $Postalcode); //bind the parameters

$sql1 = "SELECT * FROM `customer_info` WHERE `cust_name` = '$Username'";
$result1 = $con->query($sql1);
$num_rows = $result1->num_rows;
$sql2 = "SELECT * FROM `customer_info` WHERE `cust_email` = '$Email'";
$result2 = $con->query($sql2);
$num_rows2 = $result2->num_rows;

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
	echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Back</button></a>";
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
	echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Back</button></a>";
	exit();
}
}

if($num_rows > 0)
{
	echo "Username already in used.";
	echo"<br>";
	echo"<br>";
	echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Try again</button></a>";
	exit();
}
else
{	
	if($num_rows2 > 0)
  	{
		echo "Email already in used.";
	  	echo "<br>";
	  	echo "<br>";
	  	echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Try again</button></a>";
	  	exit();
  	}
  	else
  	{
		if($response["success"] === true)
		{
    		if($query->execute())
    		{
    			$sql3 = mysqli_query($con, "INSERT INTO `custlog_info` (`custlog_user`, `custlog_event`, `custlog_time`) VALUES ('$Username', '$logevent','$query_date')");
    			$sql = mysqli_query($con,"INSERT INTO `password_expiry` (`username`, `last_update`) VALUES ('$Username', '$creationdate')");
				echo "Account successfully registered";
				echo"<br>";
				echo"<br>";
				echo "<a href='http://localhost/CRUD/login_customer.php'><button type='button'>Back to main</button></a>";
				exit();
			}
			else
			{
				echo "Error registering account";
				echo"<br>";
				echo"<br>";
				echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Try again</button></a>";
				exit();
			}	
		}
		else
		{
			echo "Recaptcha error; Try again";
			echo"<br>";
			echo"<br>";
			echo "<a href='http://localhost/CRUD/customer/customer_register.html'><button type='button'>Try again</button></a>";
			exit();
		}
	}
}
?>
