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

if(isset($_POST['EditUser']))
{
	/*get variables*/
	$uid = $_SESSION['uid'];
	$username = $_POST['user'];
	$email = $_POST['email'];
	$avatar = $_POST['avatar'];
	$forum_notify = $_POST['Forum_notify'];
	$password = md5($_POST['passwd']);
	$sql = "UPDATE users SET username='{$username}',email='{$email}',forum_notify='{$forum_notify}', avatar='{$avatar}', password='{$password}'
	WHERE id={$uid} LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	/*$password = $_POST['passwd'];*/
}
if(isset($_POST['EditUser']))
{
	/*$_POST['user']
	$_POST['email']
	$_POST['avatar']
	$_POST['Forum_notify']*/
}
if(isset($_GET['name']))
{
	$name =  mysql_real_escape_string($_GET['name']);
	$sql = "SELECT * FROM users WHERE username='{$name}' LIMIT 1;";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res))
	{
		$id = $row['id'];
	}
}

/*get user things*/
if(isset($id) && $_SESSION['uid'] == $id)
{
	//same user as requested
	$userThread =  getUserThreads($_SESSION['uid']);
	$uid = $_SESSION['uid'];
	$table = getUserEdit($uid);
	$gallery = getUserGalleries($uid);
}
else if(isset($id) && is_numeric($id))
{
	$userThread =  getUserThreads($id);
	$gallery = getUserGalleries($id);
}
else if(!isset($id)) //enters the page via post, and not get
{
	$userThread =  getUserThreads($_SESSION['uid']);
	$uid = $_SESSION['uid'];
	$table = getUserEdit($uid);
	$gallery = getUserGalleries($uid);
}
else
{
	$table = "<hh4'> Something weird has happened, please dont mess with the sql Stefan..</h4>";
}
echo displayUserInfo();
echo '<div id="forum_wrapper">
	<hr/>';
echo " <div id='forum_wrapper'>";
echo isset($table)		 ? $table 		:  "";
echo isset($userThread)  ? $userThread  :  "";
echo isset($gallery) 	 ? $gallery 	:  "";
echo "</div>";
?>