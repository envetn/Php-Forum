<style>
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

	margin-bottom:5px;
	background-color:#cccccc;
	color:#000000;
}
.cat_links:hover
{
	background-color: #dddddd;
}


</style>

<?php
 session_start();
include('../include/header.php');
include_once('connect_db.php');
include('config.php');
 
echo displayUserInfo();
?>






<?php
/*
if(!isset($_SESSION['uid']))
{
	echo "<div class='leftBarUser'><p> Basic login</p><form action='login_parse.php' method='post'>
	Username<br/> <input type='text' name='username' /> &nbsp;<br/>
	Password<br/> <input type='password' name='password' />
	<input type='submit' name='submit' value='log in'></form></div>";
}
else
{
	
	echo "<div class='leftBarUser'><p>Profile</br> User: " . $_SESSION['username'] . "<br/> <a href='logout_parse.php'>logout</a></div>";
}
*/
?>

<div id="forum_wrapper">
<h2> </h2>
<hr/>

	<div id="content">
	<?php
		include_once("connect_db.php");
		$cid = $_GET['cid'];
		if(isset($_SESSION['uid'])){
			$logged = " | <a href='create_topic.php?cid={$cid}'>Create a topic </a>";
		}
		else{
			$logged = " | Please login";
		}
	$sql = "SELECT * FROM categories WHERE id='".$cid."'LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res)){
		echo "<h2> Forum categori - " . $row['category_title'] . "</h2>";
	}

		//if there exists a category
	if(mysql_num_rows($res) == 1){
		$sql2 = "SELECT * FROM topic WHERE category_id='".$cid."' ORDER BY topic_replay_date DESC";
		$res2 = mysql_query($sql2) or die(mysql_error());
		if(mysql_num_rows($res2) > 0){
			
			$topics  = "<table width='100%' style='border-collapse:collapse;'>";
			$topics .= "<tr><td colspan='3'><a href='index.php'> Return to index</a>".$logged."<br/></td></tr>";
			$topics .= "<tr style='background-color:#dddddd;'><td>Topic Title </td><td width='65' align='center'> Replies </td><td width='65' align='center'>Views</td></tr>";
			$topics .= "<tr><td colspan='3'><hr/></td></tr>";
			
		
			while($row = mysql_fetch_assoc($res2)){
			
				$tid = $row['id'];
				$title = $row['topic_title'];
				$views = $row['topic_views'];
				$date = $row['topic_date'];
				$creator = $row['topic_creator'];
				
				$maxsql = "SELECT COUNT(*) FROM posts WHERE topic_id LIKE '$tid';";
				$maxres = mysql_query($maxsql) or die(mysql_error());
				while($maxrow = mysql_fetch_assoc($maxres)){
					$max=$maxrow['COUNT(*)'] -1;
				}
				
				$topics .= "
					<td > <a class='cat_links'href='view_topic.php?cid=".$cid."&tid=".$tid."&page=0'>".$title."<br/> <span class='post_info'> Posted by: ". $creator." on ".$date."</span></a></td>";
				
				
				$topics .= "<td align='center'>$max</td><td align='center'>".$views."</td>";
				$topics .= "<tr> <td colspan='3'><hr/></td></tr>";
				
				/*$topics .=
				"<tr>
						<td valign='top' style='border: 1px solid black; padding:10px;'>  
							<a class='cat_links'href='view_topic.php?cid=".$cid."&tid=".$tid."'>".$title."
							<br/> 
							<span class='post_info'> Posted by: ".$creator." on ".$date."</span></a>
						</td>
						<td align='center'>0</td><td align='center'>".$views."</td></tr>";
				$topics .= "<tr> <td colspan='3'><hr/></td></tr>";*/
			}
			$topics .= "</table>";
		}
		else
		{
			echo "<a href='index.php'> Return to index </a><br/>";
			echo "<p> You are trying to watch a posts that does not exists".$logged."</p>";
		}
	}
	else
	{
		echo "<a href='index.php'> Return to index </a><br/>";
		echo "<p> You are trying to watch a cat that does not exists</p>";
	}
	if(isset($topics)){
		echo $topics;
	}
	?>
	</div>

</div>