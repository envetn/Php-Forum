<?php
	include_once('../connect_db.php');
	session_start();
	include("../config.php");

    $message = getUserNameFromUid($_SESSION['uid']) ." logged out in at :" . date('l jS \of F Y h:i:s A') . "\n";	
	printToLogFile("../logs/loginLogout.txt", $message);
	session_destroy();
	
	header("location: ../index.php");

?>
