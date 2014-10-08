<?php
/*
* Parseing files for uploading. 
* Using full file path to where the file is uploaded
* http://www.w3schools.com/php/php_file_upload.asp
*/
session_start();
include_once("../connect_db.php");
if(isset($_SESSION['uid'])){

	if(!is_dir( "F:/test_web/Current/working/forum/userImg/Gallery/" . $_SESSION['uid'])){
		mkdir( "F:/test_web/Current/working/forum/userImg/Gallery/" . $_SESSION['uid']);
		echo  "hellooo";
	}
	$valid_formats = array("jpg", "png"/*, "gif"*/, "zip", "bmp");
	$max_file_size = 1024*100000; //100 kb
	$path = "F:/test_web/Current/working/forum/userImg/Gallery/" .$_SESSION['uid'] ."/"; // Upload directory
	$count = 0;

	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
		// Loop $_FILES to execute all files
		/******************/
			$sql = "SELECT MAX(galleryId) AS newGalleryId FROM galleryImages";
			$res = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_assoc($res)){
				$galleryId = $row['newGalleryId'] +1;
			}
		/******************/
		foreach ($_FILES['files']['name'] as $f => $name) {     
			if ($_FILES['files']['error'][$f] == 4) {
				continue; // Skip file if any error found
			}	       
			if ($_FILES['files']['error'][$f] == 0) {	           
				if ($_FILES['files']['size'][$f] > $max_file_size) {
					$message[] = "$name is too large!.";
					continue; // Skip large files
				}
				elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
					$message[] = "$name is not a valid format";
					continue; // Skip invalid file formats
				}
				else{ // No error found! Move uploaded files 
					if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
					$count++; // Number of successfully uploaded file
					
				}
			}
			echo $name . "<br/>";
			//userImg/Gallery/Skrivbord_Sep_2014.jpg
			
			
			
			
			
			
			$fullFilePath = "userImg/Gallery/" .$_SESSION['uid'] ."/". $name;
			$g_name = $_POST['m_name'];
			$g_description = $_POST['m_description'];

			$id = $_SESSION['uid'];
			$sql = "INSERT INTO galleryImages 
			(userId,image,name,description,galleryId) VALUES ('".$id."','".$fullFilePath."','".$g_name."','".$g_description."','".$galleryId."')";
			$res = mysql_query($sql) or die(mysql_error());
			
			
			
			
			
			
			
			
			
			
			
			
		}
	}
}else{
	die("PLEASE LOG IN TO SUBMIT PORNPICTURES");
}
echo "<a href='../addGallery.php'>take me back</a>";