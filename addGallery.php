<?php
 session_start();
	include('header.php');
	include_once('connect_db.php');
	include('config.php');
echo displayUserInfo();
$galleryId ="";
if(isset($_POST['create'])){
	$sql = "SELECT MAX(galleryId) AS newGalleryId FROM galleryImages";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res)){
		$galleryId = $row['newGalleryId'] +1;
	}
	$i=0;

	while(isset($_POST['image'.$i]) && strlen($_POST['image'.$i]) > 0 ){
		$image = "userImg/Gallery/". $_POST['image'.$i];
		$name = $_POST['name'.$i]."";
		$description = $_POST['description'.$i]."";

		$id = $_SESSION['uid'];
		$sql = "INSERT INTO galleryImages 
			(userId,image,name,description,galleryId) VALUES ('".$id."','".$image."','".$name."','".$description."','".$galleryId."')";
		$res = mysql_query($sql) or die(mysql_error());
		$i ++;
		
		echo $galleryId;
	}
	
	
	
	
	
	
	
	
}
?>
<?php

$table = "<form method='post'><div style='width:800px; '><div style='width:350px; padding:20px; float:left;'>";
for($i=0;$i<1;$i++){
	 $table .= 
					  "image<input name='image".$i."' value=''></input></br>"
					  ."Name<input name='name".$i."' value=''></input></br>"
					  ."description<textarea name='description".$i."' value=''></textarea></br>";
	 } 
				    $table .= "<input type='submit' value='Submit' name='create'>
					</div>"
	    ."</div></form>";
		
		
		
		echo $table;
?>
<form action="parse/upload_file.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file"><br>
<input type="submit" name="submit" value="Submit">
</form>