<style>
#forum_wrapper{
#border:1px solid black;

}
.index_gallery{
	width:200px;
	height:150px;
	margin:1%;
}
.single_gallery{
	width:90%;
	heigth:90%;
	display: block;
    margin-left: auto;
    margin-right: auto;
}
.div_single_gallery{
  text-align:center;
  padding:5%;
}
.div_single_gallery a{

}

.div_img{
	
	width:200px;
	height:150px;
	float:left;
	padding:2% 2% 2% 2%
}
</style>
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

<?php
	$images = "";
//if isset, show single gallery
if(isset($_GET['galleryId'])){
$id = $_GET['galleryId'];
	//issnumeric
	$sql = "SELECT * 
	FROM
		galleryImages
	WHERE 
		galleryId = {$id}";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res)){

		$images .= '<div class="div_single_gallery">
			<a href="gallery.php?galleryId='.$row["galleryId"].'"><h3>'.$row['name'].'</h3><img src="'.$row["image"].'" class="single_gallery">'.$row['description'].'</a></div>';
	}
//if not, show all gallery
}else{


	$sql = "SELECT image,name, galleryId
	FROM
		galleryImages
	GROUP BY 
		galleryId
	HAVING
		COUNT(*)>0";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res)){

		$images .= '<div class="div_img">
			<a href="gallery.php?galleryId='.$row["galleryId"].'"><img src="'.$row["image"].'" class="index_gallery"><p>'.$row['name'].'</p></a></div>';
	//var_dump($row);
	}
}	
echo $images;

?>
</div>