<?php
		include_once('../connect_db.php');
	session_start();
	include("../config.php");
	$logFile = fopen("../logs/loginLogout.txt", "a+");
    $log = getUserNameFromUid($_SESSION['uid'])
	." logged out in at :" . date('l jS \of F Y h:i:s A') . "\n";
    fwrite($logFile,$log);
    fclose($logFile);
	session_destroy();
	
	header("location: ../index.php");

?>
