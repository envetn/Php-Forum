<?php

include_once("connect_db.php");


/*
x';
INSERT INTO users(username,password,email,Registered) VALUES('name','name','@email.com',now())";--
*/

if(isset($_GET['values'])){

	echo  $_GET['lastname'];
	
	$sql = "SELECT email FROM users WHERE email= '".$_GET['lastname']."'";
//	$sql = "x';INSERT INTO users(username,password,email,Registered) VALUES('name','name','x',now())";
	$res = mysql_query($sql) or die(mysql_error());
	
/*	while($row = mysql_fetch_assoc($res)){
			var_dump($row);
		}*/
}
?>
<form method="get">

Last name: <input type="text" name="lastname">
<input type="submit" value="test" name="values">
</form>