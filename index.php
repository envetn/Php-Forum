

<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
	include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

/*

*/
?>

<div id="forum_wrapper">
<hr/>
<!--<a href='search.php'>Search </a>-->
<?php
include("search.php");
$userC ="";
?>
<hr/>

<div id="content">
<?php
	
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
			$categories .= "<a class='cat_links' href='view_cat.php?cid=".$id."'>{$title}<font size='-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  {$description}</font></a>";
		}
		echo $categories;
	}
	else
	{
		echo "No category avaliable";
	}
?>
</div>

</body>
</html>