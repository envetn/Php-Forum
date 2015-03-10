<?php
	include_once('../connect_db.php');
	session_start();
	include("../config.php");

    $message = getUserNameFromUid($_SESSION['uid']) ." Logged out\n";	
	printToLogFile("../logs/loginLogout.txt", $message);
	session_destroy();
	
	header("location: ../index.php");

?>
