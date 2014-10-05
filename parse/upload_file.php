<?php
/*
*
* http://www.w3schools.com/php/php_file_upload.asp
*/session_start();
if(isset($_SESSION['uid'])){
	if(!is_dir( "F:/test_web/Current/working/forum/userImg/Gallery/" . $_SESSION['uid'])){
		mkdir( "F:/test_web/Current/working/forum/userImg/Gallery/" . $_SESSION['uid']);
		echo  "hellooo";
	}
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
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
		if (file_exists("upload/" . $_FILES["file"]["name"])) {
		  echo $_FILES["file"]["name"] . " already exists. ";
		} else {
		  move_uploaded_file($_FILES["file"]["tmp_name"],
		  "F:/test_web/Current/working/forum/userImg/Gallery/" .$_SESSION['uid'] ."/". $_FILES["file"]["name"]);
		  $fullFilePath = "F:/test_web/Current/working/forum/userImg/Gallery/" .$_SESSION['uid'] ."/". $_FILES["file"]["name"];
		  echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		}
	  }
	} else {
	  echo "Invalid file";
	}

}else{

echo "not logged in";
}?>