<style>
a
{
	color:0000ff;
}


</style>

<?php
 session_start();
include('header.php');
include_once('database.php');
include_once('connect_db.php');
include('config.php');
 
echo displayUserInfo();
?>
<div id="forum_wrapper">
<h2> </h2>
<hr/>

	<div id="content">
	<?php
		include_once("connect_db.php");
		$cid = $_GET['cid'];
		if(isset($_SESSION['uid'])){
			$logged = " | <a href='create_topic.php?cid={$cid}'><button> Create a topic </button></a>";
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
			$topics .= "<tr><td colspan='3'><a href='index.php'><button> Return to index</button></a>".$logged."<br/></td></tr>";
			$topics .= "<tr style='background-color:#dddddd;'><td>Topic Title </td><td width='65' align='center'> Replies </td><td width='65' align='center'>Views</td></tr>";
			$topics .= "<tr><td colspan='3'><hr/></td></tr>";
			
		
			while($row = mysql_fetch_assoc($res2)){
			
				$tid = $row['id'];
				$title = $row['topic_title'];
				$views = $row['topic_views'];
				$date = $row['topic_date'];
				$creator = $row['topic_creator'];
				
				$maxsql = "SELECT COUNT(*) as Count FROM posts WHERE topic_id LIKE '$tid';";
				$maxres = mysql_query($maxsql) or die(mysql_error());
				while($maxrow = mysql_fetch_assoc($maxres))
				{
					$max=$maxrow['Count'] -1;
				}
				
				$topics .= "
					<td > <a class='cat_threads'href='view_topic.php?cid=".$cid."&tid=".$tid."&page=0'>".$title."<br/> <span class='post_info'> Posted by: ". $creator." on ".$date."</span></a></td>";
				$topics .= "<td align='center'>$max</td><td align='center'>".$views."</td>";
				$topics .= "<tr> <td colspan='3'><hr/></td></tr>";
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