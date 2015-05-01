


<?php
	/*should be global for forum part*/
	
		$cid = isset($_GET['cid']) ? $_GET['cid'] : "";
		
		if(isset($_SESSION['uid']))
		{
			$logged = " | <a href='create_topic.php?cid={$cid}'><button> Create a topic </button></a>";
		}
		else
		{
			$logged = " ";//| Please login to comment";
		}
		
	$sql = "SELECT * FROM categories WHERE id=? LIMIT 1";
	$params = array($cid);
	$res = $db->queryAndFetch($sql,$params);
	
	foreach($res as $row )
	{
		echo "<h2> Forum categori - " . $row->category_title . "</h2>";
	}

		//if there exists a category
	if($db->RowCount() == 1)
	{
		$sql2 = "SELECT * FROM topic WHERE category_id=? ORDER BY topic_replay_date DESC";
		$params = array($cid);
		$res2 = $db->queryAndFetch($sql2,$params );
		if($db->RowCount() > 0)
		{
		
			$topics  = "<table width='100%' style='border-collapse:collapse;'>";
			$topics .= "<tr><td colspan='3'><a href='index.php'><button> Return to index</button></a>".$logged."<br/></td></tr>";
			$topics .= "<tr style='background-color:#dddddd;'><td>Topic Title </td><td width='65' align='center'> Replies </td><td width='65' align='center'>Views</td></tr>";
			$topics .= "<tr><td colspan='3'><hr/></td></tr>";
			
		
			foreach($res2 as $row2 )
			{
			
				$tid 	 = $row2->id;
				$title 	 = $row2->topic_title;
				$views 	 = $row2->topic_views;
				$date 	 = $row2->topic_date;
				$creator = $row2->topic_creator;
				
				$maxsql = "SELECT COUNT(*) as Count FROM posts WHERE topic_id LIKE ? ;";
				$params = array($tid);
				$maxres =  $db->queryAndFetch($maxsql,$params);
				foreach($maxres as $maxrow )
				{
					$max=$maxrow->Count -1;
				}
				
				
				//$topics .= "<td > <a class='cat_threads'href='view_topic.php?cid=".$cid."&tid=".$tid."&page=0'>".$title."<br/> <span class='post_info'> Posted by: ". $creator." on ".$date."</span></a></td>";
				$topics .= "<td > <a class='cat_threads' href='index.php?cid=".$cid."&tid=".$tid."&page=0'>".$title."<br/> <span class='post_info'> Posted by: ". $creator." on ".$date."</span></a></td>";
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
	if(isset($topics))
	{
		echo $topics;
	}
	?>
	</div>

</div>