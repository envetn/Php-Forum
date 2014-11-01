<?php
//Should only be run by admin
session_start();
include_once("../connect_db.php");
include_once("../config.php");
if(isset($_SESSION['uid'])){
	$sql = "DELETE * FROM galleryImages";
	$res = mysql_query($sql);// or die(mysql_error());
	
	//clean gallery dir
	$output = shell_exec("rm -rf /home/pi/www/forum/userImg/Gallery/*");
	echo $output;
}












?>