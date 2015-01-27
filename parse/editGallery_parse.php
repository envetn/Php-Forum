<?php
session_start();
include_once("../connect_db.php");
include_once("../config.php");

if( isset($_SESSION['uid']) /*&& (isset($_POST['id' . $]) && is_numeric($_POST['id']))*/)
{
$i = 0;
/* not secure */ 
	while(isset($_POST['id'.$i]))
	{
		 $id = mysql_real_escape_string($_POST['id'.$i]);
		 $name = mysql_real_escape_string($_POST['name']);
		 $image = mysql_real_escape_string($_POST['img'.$i]);
		 $description = mysql_real_escape_string($_POST['description'.$i]);
		$i ++;
		$sql = "UPDATE galleryImages SET name='$name' ,image='$image' , description='$description' WHERE id='$id'";
		mysql_query($sql) or die(mysql_error());
	}
	
	header("Location: ../gallery.php");

}
?>