
<?php
/*GLOBAL VARIABLES*/
$GLOBAL['database']['dsn']            = 'mysql:host=localhost;dbname=forum;'; 
$GLOBAL['database']['username']		= 'root'; // still using default settings
$GLOBAL['database']['password']		= ''; //blank for now, change it later on
$GLOBAL['database']['driver_option']	= array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");




/*
Some functions for the whole page

*/

function displayUserInfo($db)
{
	if(!isset($_SESSION['uid']))
	{
		return "<div class='leftBarUser'><form action='parse/login_parse.php' method='post'>
		<label>Username<br/> <input type='text' name='username' /> </label>&nbsp;<br/>
		<label>Password<br/> <input type='password' name='password' /></label><br/>
		<input type='submit' name='submit' value='log in'></form><a href='index.php'> Return to index</a><br/><a href='addUser.php'>Create new user</a></div>";
	}
	else
	{/*logged in*/
		$HTML = "<div class='leftBarUser'><h3>Profile</h3><p> User: " . $_SESSION['username'] . "<hr/><br/>";
		$sql = "SELECT admin FROM users WHERE username = '".$_SESSION['username'] ."' LIMIT 1";
		$res = $db->queryAndFetch($sql);
		if($db->RowCount() > 0)
		{
			foreach($res as $row )
			{
				if($row->admin == 1)
				{	
					$HTML .= "&bull;<a href='addUser.php'> Add User </a><br/>";
					$HTML .= "&bull;<a href='parse/clear_db_parse.php'> Clear image database </a></p>";
				}
			}
		}
		$HTML .= "<a href='userEdit.php'>Edit</a><br/> ";
	}
	return $HTML .= "<a href='index.php'> Return to index</a><br/>
	<a href='addGallery.php'>Create gallery</a><br/>
	<a href='parse/logout_parse.php'>logout</a></div>";

}
function getUserTable($uid)
{
	$sql = "SELECT * FROM users WHERE id = {$uid} LIMIT 1;";
	$res = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($res) > 0){
		$userTable = "<table><ul >";
		while($row = mysql_fetch_assoc($res)){
			$userTable .= "<li>Name: " . $row['username'] . "</li>"
				. "<li>Password: " . $row['password'] . "</li>" 
				. "<li>Email: " . $row['email'] . "</li>" 
				. "<li>Avatar: " . $row['avatar'] . "</li>" 
				. "<li>Registered: " . $row['Registered'] . "</li>" 
				. "<li>Forum notify" . $row['forum_notify'] . "</li>";		
				}
	$userTable .= "</ul></table";
	}
	return $userTable;
}

function getUserEdit($uid,$db)
{
	$sql = "SELECT * FROM users WHERE id=? LIMIT 1;";
	$params = array($uid);
	$res = $db->queryAndFetch($sql,$params);
	if($db->RowCount() > 0)
	{
		$userTable = "<FORM method='post' id='getUserEditForm'>";
		foreach($res as $row )
		{
			$username	  = $row->username;
			$email 		  =	$row->email;
			$avatar  	  = $row->avatar;
			$Forum_notify = $row->forum_notify;
			$passwd 	  = $row->password;
			/*$passwd = md5($passwd);*/
			$userTable .= 
			"<div style='width:800px; '>"
				  ."<div style='width:250px; padding:20px; float:left;'>"
					  ."<input name='user' value='$username'></input></br>"
					  ."<input name='email' value='$email'></input></br>"
					  ."<input name='avatar' value='$avatar'></input></br>"
					  ."<input name='Forum_notify' value='$Forum_notify'></input></br>"
					  ."<input name='passwd' value='$passwd'></input></br>"
					. "<input type='submit' value='Submit' name='EditUser'></div>"
					."<div  float:right; style='margin-bottom:10%;'>"
					  ."<img src='$avatar' width=200 alt='userAvatar' /></div>"
			."</div>"
					;
			}
		$userTable .= "</form>";
		}
		return $userTable;
}

function getUserNameFromUid($uid)
{
	$sql = "SELECT * FROM users WHERE id={$uid} LIMIT 1";
	$res = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_assoc($res))
	{
		return $row['username'];
	}


}
function getUserThreads($uid,$db)
{
	//$sql = "SELECT * FROM posts WHERE post_creator = {$uid}";
	
	
	
	$sql = "SELECT * 
	FROM posts 
	JOIN topic ON topic.id = posts.topic_id
	WHERE posts.post_creator = ? ORDER BY topic.id
	";
	$params = array($uid);
	$shortText ="";
	
	$res = $db->queryAndFetch($sql,$params);
	$userPost = "<h2> Activities</h2>";
	if($db->RowCount() > 0)
	{
		foreach($res as $row )
		{
			if(strlen($row->post_content) > 20 )
			{
				$shortenText = substr($row->post_content,0,20).'...';
			}else
			{
				$shortenText = $row->post_content;
			}
				$userPost .="<p class='getUserThreadP'><a href='view_topic.php?cid=".$row->category_id."&tid=".$row->topic_id."'>" . $shortenText . "</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font>" .$row->topic_title . "</font><br/><hr class='hr_style'/><br/></p>";
				
				
			
		}
	}
	return $userPost;
}
function getUserGalleries($uid,$db)
{
	$gallery = "<h4> Gallery</h4>";
	$sql = "SELECT * FROM galleryimages 
		WHERE UserId=?
		GROUP BY galleryId";
	$params = array($uid);
	$res = $db->queryAndFetch($sql,$params);
	foreach($res as $row )
	{
	
		$gallery .="<p class='getUserThreadP'> <a href='gallery.php?galleryId={$row->galleryId}'>{$row->name} ...</a></p>";
	}
	return $gallery;
}
/*

users ON users.id = posts.post_creator 
		topic ON topic.id = posts.topic_id
		
		SELECT * 
FROM table1 INNER JOIN table2 ON 
     table1.primaryKey=table2.table1Id INNER JOIN 
     table3 ON table1.primaryKey=table3.table1Id
*/

function searchPost($searchVal, $greedy=1,$db){
/*
	posts.topic_id -> topic.id
	and
	post_post_creator -> users.id
*/
		$returnVal = "";
	$sql = "SELECT * FROM posts
		INNER JOIN topic  
		ON posts.topic_id = topic.id
			INNER JOIN 
			users ON posts.post_creator = users.id
	WHERE posts.post_content LIKE ";
	if($greedy == 1)
	{
		$sql .= "'%".$searchVal."%'";
	}else
	{
		$sql .= "'". $searchVal."'";
	}
	$res = $db->queryAndFetch($sql);
	
	if($db->RowCount() > 0)
	{
		foreach($res as $row )
		{
		//todo: Link result to posts
			$returnVal .="<span class='staticValResult'>Content: </span>". $row->post_content."&nbsp;&nbsp;--&nbsp;&nbsp; <span class='staticValResult'>Topic:</span> " . $row->topic_title."&nbsp;&nbsp;--&nbsp;&nbsp;<span class='staticValResult'>Auther:</span>  ".$row->username ."<br/>";
		}
	}
	return $returnVal;
}

/*check if the operativsystem is linux*/
function linux_server()
{
    return in_array(strtolower(PHP_OS), array("linux", "superior operating system"));
}

function printToLogFile($file, $message)
{
	 $logFile = fopen($file, "a+");
	 fwrite($logFile,$message);
	 fclose($logFile);
}
?>