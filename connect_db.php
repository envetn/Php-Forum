<?php
/*$host = "localhost";
$username ="root";
$password = "";
$db = "forum";


mysql_connect($host,$username,$password) or die("mysql_error()");
mysql_select_db($db);


/***
perhaps not
*//*
function get_query($sql)
{
	return mysql_query($sql) or die(mysql_error());
}

function login()
{
	if(!isset($_SESSION['uid']))
	{
		$login =  "<form action='parse/login_parse.php' method='post'>Username: <input type='text' name='username' /> &nbsp;Password <input type='password' name='password' /><input type='submit' name='submit' value='log in'/>";
	}
	else
	{
		$login =  "<p> Logged in as : " . $_SESSION['username'] . "&bull; <a href='parse/logout_parse.php'>logout</a></p>";
	}
	return $login;
}*/
?>