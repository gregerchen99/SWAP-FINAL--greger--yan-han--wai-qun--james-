<?php
$link = mysqli_connect("localhost", "root", "", "encryption");
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
} //connect to database
session_start();
$user = "-1";
if(isset($_SESSION["user"])){
 $user = $_SESSION["user"];

if($user == "AUDITOR")
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

$sql_errors = 0;
 
// Check connection

 if (isset($_POST['cmdadd'])) {	
	  $sql_errors = 0;
$logid = mysqli_real_escape_string($link, $_POST['log_ID']);
$logcomment = mysqli_real_escape_string($link, $_POST 	['log_comment']);



$sql = "UPDATE log_info SET log_comment='$logcomment' WHERE log_id = $logid";
		if (mysqli_query($link, $sql)) {} 
		else $sql_errors++;
		 }
		 
		 
	 if (isset($_POST['cmdadd1'])) {	
	  $sql_errors = 0;
$logid1 = mysqli_real_escape_string($link, $_POST['log_ID1']);
$logcomment1 = mysqli_real_escape_string($link, $_POST 	['log_comment1']);



$sql = "UPDATE custlog_info SET custlog_comment='$logcomment1' WHERE custlog_id = $logid1";
		if (mysqli_query($link, $sql)) {} 
		else $sql_errors++;
		 }	 
		 
		 
  ?>

<html>


 

 
 
 
 <!DOCTYPE html>
<form action="comment.php" method="post">
<html lang="en">
<body>

	Staff Log Comment
	<br>
    <label for="Log_ID">Log ID:</label>
    <br>
    <input type="number" name="log_ID" id="Log_ID" min="1" >
    <br>
    
    <label for="Log_comment">Enter comment:</label>
    <br>
	<input type="text" name="log_comment" id="Log_comment" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Comment must begin with a character">
	<br>
    
	<br>
	<input type="submit" name="cmdadd" value="Add">
	<br>
	<br>
</form>

<form action="comment.php" method="post">
	Customer Log comment
	<br>
	<label for="Log_ID">Log ID:</label>
    <br>
    <input type="number" name="log_ID1" id="Log_ID" min="1" >
    <br>
    
    <label for="Log_comment">Enter comment:</label>
    <br>
	<input type="text" name="log_comment1" id="Log_comment" required pattern="[a-zA-Z][a-zA-Z0-9\s]*" title="Comment must begin with a character">
	<br>
    
	<br>
	<input type="submit" name="cmdadd1" value="Add">
	<br>
	
    
	<a href="http://localhost/CRUD/auditor/auditor_main.php"><input type="button"  value="Back"/>
    
</form>
</body>
</html>