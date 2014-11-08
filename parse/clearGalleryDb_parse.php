<?php
	include_once('../connect_db.php');
$sql = "DELETE FROM galleryImages";
mysql_query($sql) or die(mysql_error());



header("location: ../index.php");
?>