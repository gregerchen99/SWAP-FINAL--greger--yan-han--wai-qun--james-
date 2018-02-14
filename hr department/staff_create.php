<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "encryption");
 
if($link == false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$user = "-1";
if(isset($_SESSION["user"]))
{
	$user = $_SESSION["user"];
	if($user == "HR DEPARTMENT")
	{

	}
	else
	{
		header("Refresh:0; http://localhost/CRUD/");
		session_unset();
		session_destroy();
		exit();
	}
} 
else {
	header("Refresh:0; http://localhost/CRUD/");
	exit();
}

$Username = mysqli_real_escape_string($link, $_REQUEST['Username']);
$Email = mysqli_real_escape_string($link, $_REQUEST['Email']);
$Password = mysqli_real_escape_string($link, $_REQUEST['Password']);
$Contact = mysqli_real_escape_string($link, $_REQUEST['Contact']);
$Address = mysqli_real_escape_string($link, $_REQUEST['Address']);
$Postalcode = mysqli_real_escape_string($link, $_REQUEST['Postalcode']);
$Date = mysqli_real_escape_string($link, $_REQUEST['Date']);
$Salary = mysqli_real_escape_string($link, $_REQUEST['Salary']);
$Role = mysqli_real_escape_string($link, $_REQUEST['Position']);

$recaptcha_secret = "6LeoTEAUAAAAAGCvy9ckWncD99XglkvSrvXr5vm_";
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$_POST['g-recaptcha-response']);
$response = json_decode($response, true);
$options = ['cost' => 12];
$hash = password_hash($Password, PASSWORD_BCRYPT, $options);

//Logging variables
date_default_timezone_set('Singapore');
$query_date = date('Y-m-d H:i:s');
$logevent =  "Staff: Account created successfully";
$logevent2 = "Staff: Failed to create account; Username taken";
$logevent3 = "Staff: Failed to create account; Email taken";
$logevent4 = "Staff: Failed to create account; Connection error";
$logevent5 = "Staff: Failed to create account; Recaptcha error";
//POSTAL CODE VERIFY
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
	echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
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
	echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
	exit();
}
}

//POSTAL CODE VERIFY
$sql = "INSERT INTO `employee_info` (`employee_name`,`employee_email`, `employee_pw`, `employee_hp`, `employee_address`, `employee_postal_code`, `employee_joined_date`, `employee_salary`, `employee_role`) VALUES ('$Username', '$Email', '$hash', '$Contact', '$Address', '$Postalcode', '$Date', '$Salary', '$Role')";

$sql1 = "SELECT * FROM  `employee_info` WHERE `employee_name` = '$Username'";
$sql2 = "SELECT * FROM `employee_info` WHERE `employee_email` = '$Email'";

$result = $link->query($sql1);
$result2 = $link->query($sql2);

if($result->num_rows > 0)
{
	$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('HR DEPARTMENT', '$logevent2','$query_date')");
	echo "ERROR: Failed to create acocunt; Username taken.";
	echo "<br>";
	echo "<br>";
	echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
	exit();
}
else
{
	if($result2->num_rows > 0)
	{
		$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('HR DEPARTMENT', '$logevent3','$query_date')");
		echo "ERROR: Failed to create account; Email taken";
		echo "<br>";
		echo "<br>";
		echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
		exit();
	}
	else
	{
		if($response["success"] == true)
		{
			if(mysqli_query($link, $sql))
			{
				$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('HR DEPARTMENT', '$logevent','$query_date')");
    			echo "SUCCESS: Account created";
    			echo "<br>";
				echo "<br>";
				echo "<a href='http://localhost/CRUD/hr%20department/admin_main.php'><button type='button'>Back to main</button></a>";
				exit();
    		}
 			else
 			{
 				$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('HR DEPARTMENT', '$logevent4','$query_date')");
 				echo "ERROR: Failed to create account; Connection error. " . mysqli_error($link);
 				echo "<br>";
				echo "<br>";
				echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
				exit();
 			}
		}
		else
		{
			$sql3 = mysqli_query($link, "INSERT INTO `log_info` (`log_user`, `log_event`, `log_time`) VALUES ('HR DEPARTMENT', '$logevent5','$query_date')");
			echo "ERROR: Failed to create account; Recaptcha Error";
			echo "<br>";
			echo "<br>";
			echo "<a href='http://localhost/CRUD/hr%20department/staff_create.html'><button type='button'>Back</button></a>";
			exit();
		}
	}
}
?>