<?php
//Should only be run by admin
session_start();
include_once("../connect_db.php");
include_once("../config.php");
include("../database.php");

$db = new Database($GLOBAL['database']);
$admin = false;

if(isset($_SESSION['uid']))
{
	$sql = "SELECT id,admin FROM users WHERE id=?;";
	$params = array($_SESSION['uid']);
	$res = $db->queryAndFetch($sql,$params);
	foreach($res as $row)
	{
		if($row->admin == 1)
		{
			$admin = true;
		}
	}
	if(!$admin)
	{
		$message ="User Id: " .  $_SESSION['uid'] ." - Failed to clear Db at : " . date('l jS \of F Y h:i:s A') . "\n";
		printToLogFile("../logs/admin.txt", $message);
		header("Location: ../index.php");
	}
	else//Do I need else here?
	{

		$sql = "DELETE FROM galleryImages";
		$res = $db->queryAndFetch($sql);
		
		//clean gallery dir
		if(linux_server())
		{
			$output = shell_exec("rm -rf /home/pi/www/forum/userImg/Gallery/*");
		}else
		{
				//some command for windows 
			//nice Php could do it by itself, no need for cmd
			try
			{
			
				$dir = '../userImg/Gallery/';
				$it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
				$files = new RecursiveIteratorIterator($it,
							 RecursiveIteratorIterator::CHILD_FIRST);
				foreach($files as $file) 
				{
					if ($file->getFilename() === '.' || $file->getFilename() === '..') 
					{
						continue;
					}
					if ($file->isDir())
					{
						rmdir($file->getRealPath());
					} else
					{
						unlink($file->getRealPath());
					}
				}
				rmdir($dir);
				$message = "Database of GalleryImages was successfully cleared by UserId : ". $_SESSION['uid']." at - " . date('l jS \of F Y h:i:s A') . "\n";
				printToLogFile("../logs/admin.txt", $message);
			}
			catch(Exception $e)
			{
				$message = "Exception was raised in clear_db_parse - [ " . $e ." ] at - " . date('l jS \of F Y h:i:s A') . "\n";
				printToLogFile("../logs/admin.txt", $message);
				//header("Location: ../index.php");
				echo "<h2><a href='../index.php'>back</a> Exception was raised. Check logfiles for more information.</h2>";
			}
		}
	}
	//header("location: ".$_SERVER['PHP_SELF']);
	//header("Location: ../index.php");
}else{
	echo "Please login";
	sleep(3);
	header("Location: ../index.php");
}












?>