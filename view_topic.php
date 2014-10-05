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
	border: 1px solid #000000;
	margin-bottom:5px;
	background-color:#cccccc;
	color:#000000;
}
.cat_links:hover
{
	background-color: #dddddd;
}
table tr td
{
background:white;
}

.OP_feild{
background:green;
-moz-border-radius-bottomright: 25px 50px;
border-bottom-right-radius: 25px 50px;
}
.normal_field{
background:#FF8533;
-moz-border-radius-bottomright: 25px 50px;
border-bottom-right-radius: 25px 50px;
}
.pagin{
float:right;
margin-right:10;

font-size:1.5em;
}
</style>

<?php
 session_start();
include('header.php');
include_once('connect_db.php');
include('config.php');

echo displayUserInfo();


$cid = $_GET['cid'] ? $_GET['cid'] : 0;
$tid = $_GET['tid'];
$page_rows = 4;
$last = "";
$next = "";
$max ="";
$maxsql = "SELECT COUNT(*) FROM posts WHERE topic_id=$tid;";
$maxres = mysql_query($maxsql) or die(mysql_error());
while($maxrow = mysql_fetch_assoc($maxres)){
	$max=$maxrow['COUNT(*)'];
}
$lastPage = floor($max/10); // round down

if(isset($_GET['page'])){
	$page = $_GET['page'];
}else{
	$page = 0;
}
if($page < 0){
	$page = 0;
}elseif($page > $last){
	$pagenum = $last;
}
if($page >= $max){
	
}else{
	$next = $page + 1;
}
$previous = $page-1;


echo "<a href='view_cat.php?cid={$_GET['cid']}'>back to Categori </a>";
?>


<div id="forum_wrapper">
<h2> Forum topic</h2>

<?php


?>
<hr/>

	<div id="content">
	<?php
	$paging = "";
	
		include_once("connect_db.php");
		
		$sql = "SELECT * FROM topic WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
		$res = mysql_query($sql) or die(mysql_error());

		if(mysql_num_rows($res) == 1)
		{
			echo "<table width='100%'>";
			if(isset($_SESSION['uid'])){ 
					echo "<tr><td colspan='2'><input type='submit' value='Add replay' onClick=\"window.location='post_reply.php?cid=".$cid."&tid=".$tid."'\"/><hr/>";
					
				} 
				else
				{
					echo "<tr><td colspan='2'> <p> Please log in to reply</p>";
				}
			while($row = mysql_fetch_assoc($res)){
			
				$limit = $page * 10;
				$sql2 = "SELECT * FROM posts WHERE category_id='".$cid."' AND topic_id='".$tid."' LIMIT $limit , 10";
				
				$paging .= "<div class='pagin'> <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=0'>First</a> ";
				$paging .= " <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$previous'>&#8656; </a> &nbsp;".$page;
				$paging .= " &nbsp;<a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$next'>&#8658;</a> ";
				$paging .= " <a href='{$_SERVER['PHP_SELF']}?cid=$cid&tid=$tid&page=$lastPage'> last</a> </div>";
				
				$res2 = mysql_query($sql2) or die(mysql_error());
				
				
				
				echo $paging;
				while($row2 = mysql_fetch_assoc($res2))
				{
					/*could do this one just one sql query*/
					//fetching user info
					$sql21 = "SELECT * FROM users WHERE id='".$row2['post_creator']."'";
					$res21 = mysql_query($sql21) or die(mysql_error());
					
					while($row21 = mysql_fetch_assoc($res21)){
					$img = $row21['avatar']; $name = $row21['username']; 
					}
					if($row['topic_creator'] == $row2['post_creator']){ 
						echo "<tr>
						<td valign='top' style='border: 1px solid black;'> 
						<div style='min-height:200px; '><div class='OP_feild'>".$row['topic_title'] ."<br/> By ".$name." - ".$row2['post_date']." - Creator (OP)<hr/></div>".$row2['post_content']."</div></td>";	
					}else{
						echo "<tr>
						<td valign='top' style='border: 1px solid black;'> 
						<div style='min-height:200px;'><div class='normal_field'> By ".$name." - ".$row2['post_date']."<hr/></div>".$row2['post_content']."</div></td>";	
					}
					echo "<td width='200' valign='top' align='center' style='border:1px solid black;'>User Info Here <img src='".$img."' width='180' height='120'/></td></tr><tr> <td colspan='2'><hr/></td></tr>";
				}
				$old_views = $row['topic_views'];
				$new_views = $old_views + 1;
				$sql3 = "UPDATE topic SET topic_views='".$new_views."' WHERE category_id='".$cid."' AND id='".$tid."' LIMIT 1";
				$res3 = mysql_query($sql3) or die(mysql_error());
				
			}
			echo "</table>";
		}
		else
		{
			echo "<p> This topic does no exists</p>";
		}
	
	echo $paging;
	?>
	</div>

</div>