<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
echo displayUserInfo();
	$images = "";
if(isset($_GET['id']) && is_numeric($_GET['id'])){
$id = $_GET['id'];
	//issnumeric
	//open for injection
	$sql = "SELECT * 
	FROM
		galleryImages
	WHERE 
		galleryId = {$id}";
	$res = mysql_query($sql) or die(mysql_error());
	$images = "<h3> Edit </h3><form method='post' action='parse/editGallery_parse.php'><div class='div_single_gallery'>";
	$i = 0;
	while($row = mysql_fetch_assoc($res))
	{

		$images .= '<div class="div_single_edit_gallery">';
		$images .=	/*'<input name="name" '.$i.' value=""></input>*/'
						<input type="hidden"name="id'.$i.'" value="'.$row["id"].'"></input>
						<img src="'.$row["image"].'" class="single_gallery"/>
						<input name="img'.$i.'" value="'.$row["image"].'" type="hidden"></input>
							<p>Description: <textarea name="description'.$i.'">'. $row["description"].'</textarea></p><hr/></div>';
							$i++;
	}
  $images .= "<input type='submit' name='submit' value='Submit'> <div></form>";
}

?>
<div id="forum_wrapper">
<h2> Edit Gallery</h2>
<style>
form{
	border: 1px solid black;
	padding:0;
	margin:0;
 }
 form p{
 margin-bottom:20px;
 }

.div_single_gallery textarea{
width:60%;
}
.div_single_gallery input
 {
	width:60%;
 }
</style>
<?=$images;?>