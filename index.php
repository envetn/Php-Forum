
<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
	include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

$page = "";
if(isset($_GET['cid']))
{
	if(isset($_GET['tid']) && Isset($_GET['page']) )
	{
		$page = "view_topic";
	}
	else if(isset($_GET['reply']))
	{
		$page = "reply";
	}
	else
	{
		$page = "view_cat";
	}
}

echo "<div id='forum_wrapper'><hr/>";
include("search.php");
echo "<div id='content'>";

	if($page == "")
	{
		$sql = "SELECT * FROM categories ORDER BY category_title ASC;";
		$res = $db->queryAndFetch($sql);
		$categories = "";
		if($db->RowCount() > 0)
		{

			foreach($res as $row )
			{
				$id = $row->id;
				$title = $row->category_title;
				$description = $row->category_description;
				//$categories .= "<a class='cat_links' href='view_cat.php?cid=".$id."'>{$title}<font size='-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {$description}</font></a>";
				$categories .= "<a class='cat_links' href='index.php?cid=".$id."'>{$title}<font size='-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {$description}</font></a>";
			}
			echo $categories;
		}
		else
		{
			echo "No category avaliable";
		}
	}
	else if($page == "view_cat")
	{
		include("Forum/view_cat.php");
	}
	else if($page == "reply")
	{
		include("Forum/post_reply.php");
	}
	else if($page == "view_topic")
	{
		include("Forum/view_topic.php");
	}
?>
</div>

</body>
</html>