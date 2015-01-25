<?php
session_start();
include_once("../connect_db.php");
if(isset($_POST['user_submit']))
{
	$username = $_POST['user_name'];
	$password = md5($_POST['user_password']);
	$email = $_POST['user_email'];
	if(isset($_POST['email_notify']))
		$email_notify = $_POST['email_notify'] ;
	else
		$email_notify = 0;
	
	if( ( strpos($email, '@') == true) )//&& strpos($email, '.com') === true))
	{
		//if user is going to be admin, change that in phpmyadmin
		$sql = "INSERT INTO users(username,password,email,Registered) VALUES('".$username."','".$password ."','".$email."',now())";
		$res = mysql_query($sql) or die(mysql_error());
		
		if ($res)
			{
				echo "<p>Thank you for your registration<a href='../index.php'>\r\nReturn</p>";
			}
			else
			{
				echo "<p> There was an error, please do not try again</p>";
			}
	}
	else
			echo "<p> Not a valid email</p>";
}
else
{
echo "hallo";
	exit();
}

?>