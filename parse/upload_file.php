<?php
/*
* Parseing files for uploading. 
* Using full file path to where the file is uploaded
* http://www.w3schools.com/php/php_file_upload.asp
*/
session_start();
require_once("ImageManipulator.php");
include_once("../config.php");
include_once("../connect_db.php");
if(isset($_SESSION['uid']))
{
	if(linux_server()){

		if(!is_dir("/home/pi/www/forum/userImg/Gallery/"))
		{
			mkdir( "/home/pi/www/forum/userImg/Gallery/");
		}
		$path = "/home/pi/www/forum/userImg/Gallery/" . $_SESSION['uid'];
		if(!is_dir("/home/pi/www/forum/userImg/Gallery/" . $_SESSION['uid']))
		{
			mkdir("/home/pi/www/forum/userImg/Gallery/". $_SESSION['uid']);
			//why is does this command not work with variable?
		}
	}
	else
	{
		if(!is_dir("F:/test_web/Current/working/forum/userImg/Gallery/"))
		{
			mkdir( "F:/test_web/Current/working/forum/userImg/Gallery");
		}
		$path = "F:/test_web/Current/working/forum/userImg/Gallery/" .$_SESSION['uid'] ."/"; // Upload directory
		if(!is_dir( "F:/test_web/Current/working/forum/userImg/Gallery/". $_SESSION['uid']))
		{
			mkdir( "F:/test_web/Current/working/forum/userImg/Gallery/". $_SESSION['uid']);
			//why is does this command not work with variable?
		}
	}
	if ($_FILES['fileToUpload']['error'] > 0) 
	{
		echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
	}
	else
	{
		echo "File name: " . $_FILES['fileToUpload']['name'] . "<br />";
		echo "File type: " . $_FILES['fileToUpload']['type'] . "<br />";
		echo "File size: " . ($_FILES['fileToUpload']['size'] / 1024) . " Kb<br />";
		echo "Temp path: " . $_FILES['fileToUpload']['tmp_name'];
		// some echo
		
		    // array of valid extensions
		$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
		// get extension of the uploaded file
		$fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
		// check if file Extension is on the list of allowed ones
		if (in_array($fileExtension, $validExtensions))
		{
		/*$width  = $manipulator->getWidth();
			$height = $manipulator->getHeight();
			$centreX = round($width / 2);
			$centreY = round($height / 2);
			// our dimensions will be 200x130
			$x1 = $centreX - 100; // 200 / 2
			$y1 = $centreY - 65; // 130 / 2
	 
			$x2 = $centreX + 100; // 200 / 2
			$y2 = $centreY + 65; // 130 / 2
	 
			// center cropping to 200x130
			$newImage = $manipulator->crop($x1, $y1, $x2, $y2);*/
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
			
			list($width,$height) = getimagesize($_FILES['fileToUpload']['tmp_name']);
			if($width > 1080 || $height > 950) //resize
			{
				$newImage = $manipulator->resample(1080, 950);
			}
		
			$destination = 'F:/test_web/Current/working/forum/userImg/Gallery/' . $_SESSION['uid'] . '/';	
			$manipulator->save($destination . $newNamePrefix . $_FILES['fileToUpload']['name']);
			
			//Upload data to database.
			$sql = "SELECT MAX(galleryId) AS newGalleryId FROM galleryImages";
			$res = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_assoc($res)){
				$galleryId = $row['newGalleryId'] +1;
			}
			$fullFilePath = "userImg/Gallery/" .$_SESSION['uid'] ."/". $newNamePrefix . $_FILES['fileToUpload']['name'];
			$name = "1";//$_POST['name'.$i]."";
			$description = "asd";//$_POST['description'.$i]."";

			$id = $_SESSION['uid'];
			$sql = "INSERT INTO galleryImages 
			(userId,image,name,description,galleryId) VALUES ('".$id."','".$fullFilePath."','".$name."','".$description."','".$galleryId."')";
			$res = mysql_query($sql) or die(mysql_error());
		}
		else 
		{
        echo 'You must upload an image...';
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);

	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	//|| ($_FILES["file"]["type"] == "image/pjpeg")
	//|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 2000000)
	&& in_array($extension, $allowedExts)) {
	  if ($_FILES["file"]["error"] > 0) {
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	  } else {
	
		if (file_exists("upload/" . $_FILES["file"]["name"])) {
		  echo $_FILES["file"]["name"] . " already exists. ";
		} else {
		  move_uploaded_file($_FILES["file"]["tmp_name"],
		  "F:/test_web/Current/working/forum/userImg/Gallery/" .$_SESSION['uid'] ."/". $_FILES["file"]["name"]);
		  
			$sql = "SELECT MAX(galleryId) AS newGalleryId FROM galleryImages";
			$res = mysql_query($sql) or die(mysql_error());
			while($row = mysql_fetch_assoc($res)){
				$galleryId = $row['newGalleryId'] +1;
			}
			$fullFilePath = "userImg/Gallery/" .$_SESSION['uid'] ."/". $_FILES["file"]["name"];
			$name = "1";//$_POST['name'.$i]."";
			$description = "asd";//$_POST['description'.$i]."";

			$id = $_SESSION['uid'];
			$sql = "INSERT INTO galleryImages 
			(userId,image,name,description,galleryId) VALUES ('".$id."','".$fullFilePath."','".$name."','".$description."','".$galleryId."')";
		$res = mysql_query($sql) or die(mysql_error());
		  header("location: ../gallery.php");
		  
		
		}
	  }*/
	}
	else
	{
	  echo "Invalid file";
	}

?>