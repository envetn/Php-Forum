<?php
/*
* Parseing files for uploading. 
* Using full file path to where the file is uploaded
* http://www.w3schools.com/php/php_file_upload.asp
*/
session_start();
include_once("../config.php");
include("../database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);

if(isset($_SESSION['uid']))
{
	$mb = 100000000;
	$kb = 100000;
	$message = "";
	require_once("ImageManipulator.php");
	if(linux_server())
	{
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
	}else{

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
		$valid_formats = array("jpg", "png"/*, "gif"*/, "zip", "bmp");
		
		$max_file_size = 1024*(10*$mb); 
		$count = 0;

		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			
			// Loop $_FILES to execute all files
			/******************/
				$sql = "SELECT MAX(galleryId) AS newGalleryId FROM galleryImages";
				$res = $db->queryAndFetch($sql);
				foreach($res as $row )
				{
					$galleryId = $row->newGalleryId +1;
				}
				
				
			/******************/
			$i = 0;
			foreach ($_FILES['files']['name'] as $f => $name)
			{   
		
			$message = "Error messages: </br>";
				if ($_FILES['files']['error'][$f] == 4) 
				{
					$message .= "Error found on one of the files : ".$_FILES['files']['error'][$f]." <br/>";
					continue; // Skip file if any error found
				}	       
				if ($_FILES['files']['error'][$f] == 0) 
				{	           
					if ($_FILES['files']['size'][$f] > $max_file_size) 
					{
						$message .= "$name is too large!.";
						continue; // Skip large files
					}
					elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) )
					{
						$message .= "<br/>$name is not a valid format";
						continue; // Skip invalid file formats
					}
					else
					{ // No error found! Move uploaded files 
						$manipulator = new ImageManipulator($_FILES['files']['tmp_name'][$f]);
						list($width,$height) = getimagesize($_FILES['files']['tmp_name'][$f]);
						$newNamePrefix = time() . '_';
						if($width > 1080 || $height > 950) //resize
						{
							$newImage = $manipulator->resample(1080, 950);
						}
						$destination = 'F:/test_web/Current/working/forum/userImg/Gallery/' . $_SESSION['uid'] . '/';	
						$manipulator->save($destination . $newNamePrefix . $_FILES['files']['name'][$f]);
					
					
						/*if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.DIRECTORY_SEPARATOR.$name))
							$count++; // Number of successfully uploaded file*/
						
						echo "Added: " . $path .DIRECTORY_SEPARATOR. $name . "<br/>";
						
						$fullFilePath = "userImg/Gallery/" .$_SESSION['uid'] ."/". $newNamePrefix . $_FILES['files']['name'][$f];
						$g_name = $_POST['m_name'];
						$g_description = $_POST['m_description'];

						$id = $_SESSION['uid'];
						$sql = "INSERT INTO galleryImages 
						(userId,image,name,description,galleryId) VALUES (?,?,?,?,?)";
						$params = array($id,$fullFilePath,$g_name,$g_description,$galleryId);
						$res = $db->queryAndfetch($sql,$params);
						echo $name . "<br/>";
					}
				}
				else
				{
					$message .= $_FILES['files']['error'][$f] ." != 0. Filenumber: " . $f;
				}
				
				//userImg/Gallery/Skrivbord_Sep_2014.jpg
				
				
				
				
				
				
				
				
				
			echo "<pre" . var_dump($_FILES) . "</pre></hr>";
			echo "<pre>" . $message . "</pre>";
			}			
		}
	
}else{
	die("PLEASE LOG IN TO SUBMIT PORNPICTURES");
}
echo "<a href='../addGallery.php'>take me back</a> " . isset($_SESSION['uid']);