
<?php
//an other gallery, yes..
//but this one I will put more effort into.
//like commenting,uploading or just scrolling though


?>
<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
echo displayUserInfo();
?>

<div id="forum_wrapper">
<h2> Gallery</h2>
<style>

#forum_wrapper
{
width:80%;
padding-left:20%;
}

</style>
<?php

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
				<img src="'.$row["image"].'"style="width:250px; height:250px;"/></a><p>'.$row['name'].'</p>
			</div>';
	//var_dump($row);
	}
	$images .= '</div>';
}	
echo $images;

?>
</div>