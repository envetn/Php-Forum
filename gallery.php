
<?php
//an other gallery, yes..
//but this one I will put more effort into.
//like commenting,uploading or just scrolling though
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
echo displayUserInfo();

function showEdit()
{
	
	/*
	Inloggad som lofie, u_uid = 1
	Om gallery med id 1 har g_uid == u_uid
	visa edit
	
	
	*/
	if( isset($_SESSION['uid']) && (isset($_GET['galleryId']) && is_numeric($_GET['galleryId'])))
	{
		$uid = $_SESSION['uid'];
		$g_uid = $_GET['galleryId'];
		
		$sql = "SELECT * FROM galleryImages WHERE UserId={$uid} AND galleryId={$g_uid} LIMIT 1";
		$res = mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($res) == 1)
		{
			$id = $_GET['galleryId'];
			
			return " - <a href='editGallery.php?id=$id'> Edit </a>" . $uid;
		}else
		{
			return false;
		}
		}
}
?>
<?php

?>

<div id="forum_wrapper">
<h2> Gallery <?=showEdit()?></h2>
<style>

</style>
<?php
//get user id from userImages.
// if SESSION($uid) == userImages id, show edit
	$images = "";
//if isset, show single gallery
if(isset($_GET['galleryId']) && is_numeric($_GET['galleryId'])){
$id = $_GET['galleryId'];
	//issnumeric
	//open for injection
	$sql = "SELECT * 
	FROM
		galleryImages
	WHERE 
		galleryId = {$id}";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res)){

		$images .= '<div class="div_single_gallery">
			<h3>'.$row['name'].'</h3><img src="'.$row["image"].'" class="single_gallery">'.$row['description'].'</div>';
	}
//if not, show all galleries
}else{


	$sql = "SELECT image,name, galleryId
	FROM
		galleryImages
	GROUP BY 
		galleryId
	HAVING
		COUNT(*)>0";
	$res = mysql_query($sql) or die(mysql_error());
	$images = '<div id="parent_image">';
	while($row = mysql_fetch_assoc($res)){
		$images .= 
		'	<div class="child_image">
			<a href="gallery.php?galleryId='.$row["galleryId"].'">
				<img src="'.$row["image"].'"/></a><p>'.$row['name'].'</p>
			</div>';
	//var_dump($row);
	}
	$images .= '<div style="clear:both"></div>';
	$images .= '</div>';
}	
echo $images;

?>
</div>