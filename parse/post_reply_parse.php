<?php
session_start();
include_once("../connect_db.php");
include('../src/Class/TextFilter/TextFilter.php');
include_once("../config.php");
include("../database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);
$filter = new TextFilter();
$now  = date('Y-m-d H:i:s');
if($_SESSION['uid'])
{
	if(isset($_POST['reply_submit']))
	{
		$creator = $_SESSION['uid'];
		$cid = $_POST['cid'];
		$tid = $_POST['tid'];
		$reply_content = $_POST['reply_content'];
		$reply_content = $filter->doFilter($reply_content, "nl2br,link,bbcode");
		
		$sql = "INSERT INTO posts (category_id, topic_id, post_creator, post_content,post_date) VALUES(?,?,?,?,?)";
		$params = array($cid,$tid,$creator,$reply_content,$now);
		$res = $db->queryAndFetch($sql,$params);
		
		$sql2 = "UPDATE categories SET last_post_date=now(), last_user_posted=? WHERE id=? LIMIT 1";
		$params = array($creator,$cid);
		$res2 = $db->queryAndFetch($sql2,$params);
		
		$sql3 = "UPDATE topic SET topic_replay_date=now(), topic_last_user='".$creator."' WHERE id='".$tid."' LIMIT 1";
		$params = array($creator,$tid);
		$res3 = $db->queryAndFetch($sql3,$params);
		
		
		//email sending
		/*
		
		
		*/
		$sql4 = "SELECT post_creator FROM posts WHERE category_id=? AND topic_id=? GROUP BY post_creator";
		$params = array($cid,$tid);
		$res4 = $db->queryAndFetch($sql4,$params);
		$userId[] = null;
		
		foreach($res4 as $row4 )
		{
			$userId[] .= $row4->post_creator;
		}
		foreach($userId as $key)
		{
			$sql5 = "SELECT id,email FROM users WHERE id=? AND forum_notify='1' LIMIT 1";
			$params = array($key);
			$res5 = $db->queryAndFetch($sql5,$params);
			if($db->RowCount() > 0)
			{
				$email = "";
				foreach($res5 as $row5 )
				{
					if($row5->id != $creator)
					{
						$email .= $row5->email . ", ";
					}
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
		
	
		
		
		
		/*if( ($res) && ($res2) && ($res3) ) 
		{
			header("location: ../view_topic.php?cid=".$cid."&tid=".$tid."");
		}
		else
		{
			echo "<p> There was an error, please do not try again</p>";
		}*/
		header("location: ../view_topic.php?cid=".$cid."&tid=".$tid."");
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