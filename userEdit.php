<style>

#new
.userTable{
padding:2000px;
}
ul{
padding-left:22%;
width:auto;
}

</style>
<?php
session_start();
include('header.php');
include_once('connect_db.php');
include('config.php');

if(isset($_POST['EditUser'])){
	/*get variables*/
	$uid = $_SESSION['uid'];
	$username = $_POST['user'];
	$email = $_POST['email'];
	$avatar = $_POST['avatar'];
	$forum_notify = $_POST['Forum_notify'];
	$password = md5($_POST['passwd']);
	var_dump($_POST);
	$sql = "UPDATE users SET username='{$username}',email='{$email}',forum_notify='{$forum_notify}', avatar='{$avatar}', password='{$password}'
	WHERE id={$uid} LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	/*$password = $_POST['passwd'];*/
}
if(isset($_POST['EditUser'])){
	/*$_POST['user']
	$_POST['email']
	$_POST['avatar']
	$_POST['Forum_notify']*/
}
echo displayUserInfo();

if(isset($_SESSION['uid'])){
	$uid = $_SESSION['uid'];
	$table = getUserEdit($uid);
}else{
	die("Error on selecting user");
}

echo $table;

echo " <div id='forum_wrapper'>";

/*get user things*/
		echo getUserThreads($_SESSION['uid']);

?>