

<?php
 session_start();
include('header.php');
include_once('connect_db.php');
include('config.php');
include("database.php");
$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);


//pre variables
$cid = is_numeric($_GET['cid']) ? $_GET['cid'] : 0 ;
$tid = is_numeric($_GET['tid']) ? $_GET['tid'] : 0 ;
$page_rows = 4;
$last = "";
$next = "";
$max ="";
$maxsql = "SELECT COUNT(*) as COUNT FROM posts WHERE topic_id=$tid;";
$maxres = $db->queryAndFetch($maxsql);

foreach($maxres as $maxrow )
{
	$max=$maxrow->COUNT;
}
$lastPage = floor($max/10); // round down

if(isset($_GET['page']))
{
	$page = is_numeric($_GET['page']) ? $_GET['page'] : 0 ;
}else
{
	$page = 0;
}
if($page < 0)
{
	$page = 0;
}
elseif($page > $last)
{
	$pagenum = $last;
}
if($page >= $max)
{
	
}else
{
	$next = $page + 1;
}
$previous = $page-1;



?>
<div id="forum_wrapper">
<hr/>


<?php
include("search.php");

?>
<hr/>

	<div id="content">
	<h2> Forum topic</h2>
	<a href='view_cat.php?cid=<?=$cid?>'>back to Categori </a>
	<?php
	$paging = "";
	
		include_once("connect_db.php");
		
		$sql = "SELECT * FROM topic WHERE category_id=? AND id=? LIMIT 1";
		$params = array($cid,$tid);
		$res = $db->queryAndFetch($sql,$params);

		if($db->RowCount() == 1)
		{
			echo "<table width='100%'>";
			if(isset($_SESSION['uid']))
			{ 
					echo "<tr><td colspan='2'><input type='submit' value='Add replay' onClick=\"window.location='post_reply.php?cid=".$cid."&tid=".$tid."'\"/><hr/>";
					
				} 
				else
				{
					echo "<tr><td colspan='2'> <p> Please log in to reply</p>";
				}
				foreach($res as $row )
				{
			
					$limit = $page * 10;
					
					
					$paging .= "<div class='pagin'> <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=0'>First</a> ";
					$paging .= " <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$previous'>&#8656; </a> &nbsp;".$page;
					$paging .= " &nbsp;<a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$next'>&#8658;</a> ";
					$paging .= " <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$lastPage'> last</a> </div>";
					
					$sql2 = "SELECT * FROM posts WHERE category_id=? AND topic_id=? LIMIT $limit , 10";
					$params = array($cid,$tid);
					$res2 = $db->queryAndFetch($sql2,$params);
					echo $paging;
					
					
					foreach($res2 as $row2 )
					{
					/*could do this one just one sql query*/
					//fetching user info
					$sql21 = "SELECT * FROM users WHERE id=?";
					$params = array($row2->post_creator);
					$res21 = $db->queryAndFetch($sql21,$params);
				
					foreach($res21 as $row21 )
					{
						$img = $row21->avatar;
						$name = $row21->username; 
					
						
					}
					if($row->topic_creator == $row2->post_creator)
					{ 
						$name 	= isset($name) 	? $name	 : "Unknow";
						$img 	= isset($img) 	? $img	 : "userImg/default.jpg";
						echo "<tr>
						<td valign='top' style='border: 1px solid black;'> 
						<div style='min-height:200px; '><div class='OP_feild'>".$row->topic_title ."<br/> By ".$name." - ".$row2->post_date." - Creator (OP)<hr/></div>".$row2->post_content."</div></td>";	
					}
					else
					{
						echo "<tr>
						<td valign='top' style='border: 1px solid black;'> 
						<div style='min-height:200px;'><div class='normal_field'> By ".$name." - ".$row2->post_date."<hr/></div>".$row2->post_content."</div></td>";	
					}
					
					echo "<td width='200' valign='top' align='center' style='border:1px solid black;'>User: <a href='userEdit.php?name=".$name."'>".$name."</a><img src='".$img."' width='180' height='120'/></td></tr><tr> <td colspan='2'><hr/></td></tr>";
				}
				$old_views = $row->topic_views;
				$new_views = $old_views + 1;
				$sql3 = "UPDATE topic SET topic_views=? WHERE category_id=? AND id=? LIMIT 1";
				$params = array($new_views,$cid,$tid);
				$res3 = $db->ExecuteQuery($sql3,$params);

				
			}
			echo "</table>";
		}
		else
		{
			echo "<p> There was an error, please refresh the page</p>";
		}
	
	echo $paging;
	?>
	</div>

</div>