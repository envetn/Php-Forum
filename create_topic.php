<?php  
session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
		include("database.php");
$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

if((!isset($_SESSION['uid'])) || ($_GET['cid'] =="" ))
{
	header("Location: index.php");
}
else
{
	//no else
}
$cid = $_GET['cid'];
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
<h2> Forum - create topic</h2>

<?php
echo "<p> Logged in as : " . $_SESSION['username'] . "&bull; <a href='parse/logout_parse.php'>logout</a>";

?>
<hr/>

	<div id="content">
	<form action="parse/create_topic_parse.php" method="post">
	<p>Topic title</p>
	<input type='text' name='topic_title' size='50' maxlength='150'/>
	<p>Topic Content </p>
	<textarea name='topic_content' rows='10' cols='20'></textarea><br/><br/>
	<input type='hidden' name='cid' value='<?php echo $cid;?>'/>
	<input type='submit' name='topic_submit' value='Create your topic' />
	</div>

</div>