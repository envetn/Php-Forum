
 
<?php
//an other gallery, yes..
//but this one I will put more effort into.
//like commenting,uploading or just scrolling though
 session_start();
	include('header.php');
	include('config.php');
	include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

function showEdit($db)
{
	if( isset($_SESSION['uid']) && (isset($_GET['galleryId']) && is_numeric($_GET['galleryId'])))
	{
		$uid = $_SESSION['uid'];
		$g_uid = $_GET['galleryId'];
		
		$sql = "SELECT * FROM galleryImages WHERE UserId=? AND galleryId=? LIMIT 1";
		$params = array($uid,$g_uid);
		$res = $db->queryAndFetch($sql,$params);
		if($db->RowCount() == 1)
		{
			$id = $_GET['galleryId'];
			return " - <a href='editGallery.php?id=$id'> Edit </a>";
		}else
		{
			return false;
		}
	}
}
?>


<div id="forum_wrapper">
<hr/>
<h2> Gallery <?=showEdit($db)?></h2>
<style>

</style>
<?php
//get user id from userImages.
// if SESSION($uid) == userImages id, show edit
	$images = "";
//if isset, show single gallery
$image ="";
if(isset($_GET['galleryId']) && is_numeric($_GET['galleryId']))
{
	$id = is_numeric($_GET['galleryId']) ? $_GET['galleryId'] : 0;
	//issnumeric
	//open for injection
	$sql = "SELECT * 
	FROM
		galleryImages
	WHERE 
		galleryId=?";
	$params = array($id);
	$res = $db->queryAndFetch($sql,$params);
	$images .= '<div class="div_single_gallery">';
	$i = 0; //ugly as hell
	foreach($res as $row )
	{
		
		/*$images .= '<div class="div_single_gallery">
			<h3>'.$row['name'].'</h3><a href="#3" class="lightbox"><img src="'.$row["image"].'" class="single_gallery"></a>'.$row['description'].'</div>';
			$image = $row['image'];*/
			if($i == 0)
			{
				$images .= '<h3>'.$row->name.'</h3>';
				$i ++;
			}	
			$images .= '<a href="'.$row->image.'"><img src="'.$row->image.'" class="single_gallery"></a>'.$row->description;
			$image = $row->image;
			
	}
$images .= '</div>';
//if not, show all galleries
}
else
{


	$sql = "SELECT image,name, galleryId
	FROM
		galleryImages
	GROUP BY 
		galleryId
	HAVING
		COUNT(*)>0";
	$res = $db->queryAndFetch($sql);
	$images = '<div id="parent_image">';
	foreach($res as $row )
	{
		$images .= 
		'<div class="child_image">
			<a href="gallery.php?galleryId='.$row->galleryId.'">
			<img src="'.$row->image.'"/></a><p>'.$row->name.'</p>
		</div>';
	}
	$images .= '<div style="clear:both"></div>';
	$images .= '</div>';
}	
echo $images;





?>
<a href="#3" class="lightbox">Open Lightbox</a>
	<div class="backdrop"></div>
	<div class="box"><div class="close">x</div><img src="userImg/Gallery/1/214950_2014-08-31_00005.png" style='width:100%'/></div>

	

</div>