<?php
session_start();
include_once("connect_db.php");
include('../src/Class/TextFilter/TextFilter.php');
$filter = new TextFilter();
if($_SESSION['uid'])
{
	if(isset($_POST['reply_submit']))
	{
		$creator = $_SESSION['uid'];
		$cid = $_POST['cid'];
		$tid = $_POST['tid'];
		$reply_content = $_POST['reply_content'];
		$reply_content = $filter->doFilter($reply_content, "nl2br,link,bbcode");
		
		$sql = "INSERT INTO posts (category_id, topic_id, post_creator, post_content,post_date) VALUES('".$cid."','".$tid."','".$creator."','".$reply_content."',now())";
		$res = mysql_query($sql) or die(mysql_error());
		
		$sql2 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' LIMIT 1";
		$res2 = mysql_query($sql2) or die(mysql_error());
		
		$sql3 = "UPDATE topic SET topic_replay_date=now(), topic_last_user='".$creator."' WHERE id='".$tid."' LIMIT 1";
		$res3 = mysql_query($sql3) or die(mysql_error());
		
		
		//email sending
		/*
		
		
		*/
		$sql4 = "SELECT post_creator FROM posts WHERE category_id='".$cid."' AND topic_id='".$tid."' GROUP BY post_creator";
		$res4 = mysql_query($sql4) or die(mysql_error());
		$userId[] = null;
		while($row4 = mysql_fetch_assoc($res4))
		{
			$userId[] .= $row4['post_creator'];
		}
		foreach($userId as $key)
		{
			$sql5 = "SELECT id,email FROM users WHERE id='".$key."' AND forum_notify='1' LIMIT 1";
			$res5 = mysql_query($sql5) or die(mysql_error());
			if(mysql_num_rows($res5) > 0)
			{
				$email = "";
					$row5 = mysql_fetch_assoc($res5);
					if($row5['id'] != $creator)
					{
						$email .= $row5['email'] . ", ";
					}
			}
		}
		$email = substr($email,0,(strlen($email) -2));
	
	
	
			$to = "noreplay@somewhat.com";
			$from = "lofielus92@gmail.com";
			$bcc = $email;
			$subject = "Forum reply from blalbal";
			
			$message = "";
			
			//$header "From: $from\r\nReply-To: $from " . mailto($to,$subject,$message,$header);
		
	
		
		
		
		if( ($res) && ($res2) && ($res3) ) 
		{
			header("location: view_topic.php?cid=".$cid."&tid=".$tid."");
		}
		else
		{
			echo "<p> There was an error, please do not try again</p>";
		}
		
	}
	else
	{
		exit();
	}
}
else
{
	exit();
}

?>