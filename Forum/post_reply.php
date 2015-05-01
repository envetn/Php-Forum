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



<h2> Forum - reply post</h2>
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

