<?php
session_start();

include("../database.php");
include("../config.php");
$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);


if(($_SESSION['uid'] == "") )
{
	header("Location: ../index.php");
}
	exit();

if(isset($_POST['topic_submit']))
{
	
	
	if(($_POST['topic_title'] == "") && ($_POST['topic_content'] == ""))
	{
		echo "You did not fill in all field";
		header("Location: ../view_topic.php");
		exit();
	}
	else
	{
		
		$cid = is_numeric($_POST['cid']) ? $_POST['cid'] : 0 ;
		$title = $_POST['topic_title'];
		$content = $_POST['topic_content'];
		$creator = $_SESSION['uid'];
		$sql = "INSERT INTO topic (category_id, topic_title,topic_creator, topic_date,topic_replay_date,topic_content) VALUES(?,?,?,now(), now(),?)";
		$params = array($cid,$title,$creator,$content);
		$db->queryAndFetch($sql,$params);
		
		$new_topic_id = $db->lastInsertId();
		$sql2 = "INSERT INTO posts (category_id, topic_id, post_creator, post_content, post_date) VALUES (?,?,?,?,now())";
		$params = array($cid,$new_topic_id,$creator,$content);
		$db->queryAndFetch($sql2,$params);
			
		$sql3 = "UPDATE categories SET last_post_date=now(), last_user_posted='".$creator."' WHERE id='".$cid."' LIMIT 1";
		$db->queryAndFetch($sql3);
	/*	if( ($res) && ($res2) && ($res3) )
		{
			header("Location: ../view_topic.php?cid".$cid."&tid=".$new_topic_id);
		}
		else
		{
			echo "The res failed";
		}
	*/
	header("Location: ../view_topic.php?cid".$cid."&tid=".$new_topic_id);
	}	
	
}
?>