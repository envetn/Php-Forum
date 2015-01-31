<?php  session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
	
include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

?>
<?php 
if((!isset($_SESSION['uid'])) || ($_GET['cid'] =="" ))
{
	header("Location: ../index.php");
}
else
{
	//no else
}
$cid = $_GET['cid'];
$tid = $_GET['tid']
?>
<style>
#forum_wrapper
{
 width:800px;
 margin-left:auto;
 margin-right:auto;
}
a
{
	color:0000ff;
}
.cat_links
{
	display:block;
	padding: 5px;
	padding-top: 10px;
	padding-bottom:10px;
	border: 1px solid #000000;
	margin-bottom:5px;
	background-color:#cccccc;
	color:#000000;
}
.cat_links:hover
{
	background-color: #dddddd;
}
</style>


<div id="forum_wrapper">
<h2> Forum - reply post</h2>
<p> Basic login</p>
<?php
echo "<p> Logged in as : " . $_SESSION['username'] . "&bull; <a href='parse/logout_parse.php'>logout</a>";

?>
<hr/>

	<div id="content">
	<form action="parse/post_reply_parse.php" method="post">
	<p> Reply content</p>
	<textarea name="reply_content" rows="5" cols="75"></textarea>
	<br/>
	<input type="hidden" name="cid" value="<?php echo $cid;?>"/>
	<input type="hidden" name="tid" value="<?php echo $tid;?>"/>
	<input type="submit" name="reply_submit" value="Post your reply"/>
	</div>

</div>