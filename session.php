<?php

   if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1000) {
	session_regenerate_id(true);
    header("location: timeout.php");  
    $_SESSION['CREATED'] = time(); 
}
?>