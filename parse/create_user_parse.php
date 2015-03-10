<?php
session_start();
include_once("../config.php");
		include("../database.php");

$db = new Database($GLOBAL['database']);
if(isset($_POST['user_submit']))
{
	$username = $_POST['user_name'];
	$password = md5($_POST['user_password']);
	$email = $_POST['user_email'];
	if(isset($_POST['email_notify']))
		$email_notify = $_POST['email_notify'] ;
	else
		$email_notify = 0;
	$img = /*isset($_POST['user_Image']) ? $_POST['user_Image'] :*/ "userImg/default.jpg";
	$now = date('Y-m-d H:i:s');

	if( ( strpos($email, '@') == true) )//&& strpos($email, '.com') === true))
	{
		//if user is going to be admin, change that in phpmyadmin
		$sql = "INSERT INTO users(username,password,email,Registered, avatar) VALUES(?,?,?,?,?)";
		$params = array($username,$password,$email,$now,$img);
		$res = $db->queryAndFetch($sql,$params);
		header("Location: ../addUser.php?s=0");
	}
	else
	{
		header("Location: ../addUser.php?s=0");
	}
			
}
else
{
echo "hallo";
	exit();
}

?>