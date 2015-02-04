<?php
session_start();

include_once('../database.php');
include_once('../config.php');


if(isset($_POST['username']))
{
	$db = new Database($GLOBAL['database']);
	 $username = $_POST['username'];
	 $passwd = md5($_POST['password']);
	 $sql = "SELECT * FROM users WHERE username=? AND password=? LIMIT 1";
	 $params = array($username,$passwd);
	$res = $db->queryAndFetch($sql,$params);
	 if($db->RowCount() == 1)
	 {
		  foreach($res as $row )
		  {
			    $_SESSION['uid'] = $row->id;
				$_SESSION['username'] = $row->username;
				break;
		  }
		
		   $message = $username ." logged in at :" . date('l jS \of F Y h:i:s A') . "\n";
		   printToLogFile("../logs/loginLogout.txt", $message);
		   header("Location: ../index.php");
 }
 else
 {
	echo "invalid password or user";
	exit();
 }
}