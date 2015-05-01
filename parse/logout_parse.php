<?php

	include_once('../database.php');
	session_start();
	include("../config.php");
	$db = new Database($GLOBAL['database']);

    $message = getUserNameFromUid($_SESSION['uid'],$db ) ." Logged out\n";	
	printToLogFile("../logs/loginLogout.txt", $message);
	session_destroy();
	
	header("location: ../index.php");

?>
