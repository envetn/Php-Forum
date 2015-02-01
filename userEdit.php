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

include('config.php');
include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

if(isset($_POST['EditUser']))
{
	/*get variables*/
	$uid = $_SESSION['uid'];
	$username = $_POST['user'];
	$email = $_POST['email'];
	$avatar = $_POST['avatar'];
	$forum_notify = $_POST['Forum_notify'];
	$password = md5($_POST['passwd']);
	$sql = "UPDATE users SET username=?,email=?,forum_notify=?, avatar=?, password=?
	WHERE id=? LIMIT 1";
	$params = array($username,$email,$forum_notify,$avatar,$password,uid);
	$res = $db->queryAndFetch($sql,$params);
	var_dump($res);
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
	$sql = "SELECT * FROM users WHERE username=? LIMIT 1;";
	$params = array($name);
	$res = $db->queryAndFetch($sql,$params);
	foreach($res as $row )
	{
		$id = $row->id;
	}
}

/*get user things*/
if(isset($id) && $_SESSION['uid'] == $id)
{
	//same user as requested
	$userThread =  getUserThreads($_SESSION['uid'],$db);
	$uid = $_SESSION['uid'];
	$table = getUserEdit($uid,$db);
	$gallery = getUserGalleries($uid,$db);
}
else if(isset($id) && is_numeric($id))
{
	$userThread =  getUserThreads($id,$db);
	$gallery = getUserGalleries($uid,$db);
}
else if(!isset($id)) //enters the page via post, and not get
{
	$userThread =  getUserThreads($_SESSION['uid'],$db);
	$uid = $_SESSION['uid'];
	$table = getUserEdit($uid,$db);
	$gallery = getUserGalleries($uid,$db);
}
else
{
	$table = "<hh4'> Something weird has happened, please dont mess with the sql Stefan..</h4>";
}

echo '<div id="forum_wrapper">
	<hr/>';
echo " <div id='forum_wrapper'>";
echo isset($table)		 ? $table 		:  "";
echo isset($userThread)  ? $userThread  :  "";
echo isset($gallery) 	 ? $gallery 	:  "";
echo "</div>";
?>