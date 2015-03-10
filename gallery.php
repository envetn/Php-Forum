
 
<?php
//an other gallery, yes..
//but this one I will put more effort into.
//like commenting,uploading or just scrolling though
 session_start();
	include('header.php');
	include('config.php');
	include("database.php");

$db = new Database($GLOBAL['database']);
echo displayUserInfo($db);
$page = 0;
function showEdit($db)
{
	if( isset($_SESSION['uid']) && (isset($_GET['galleryId']) && is_numeric($_GET['galleryId'])))
	{
		$uid = $_SESSION['uid'];
		$g_uid = $_GET['galleryId'];
		
		$sql = "SELECT * FROM galleryImages WHERE UserId=? AND galleryId=? LIMIT 1";
		$params = array($uid,$g_uid);
		$res = $db->queryAndFetch($sql,$params);
		if($db->RowCount() == 1)
		{
			$id = $_GET['galleryId'];
			//return " - <a href='editGallery.php?id=$id'> Edit </a>";
			return " - <a href='gallery.php?id=$id&page=Edit'> Edit </a>";
		}else
		{
			return false;
		}
	}
}

function editGallery($db)
{	
	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$images = "";
		$id = $_GET['id'];
		$uid = $_SESSION['uid'];
		//issnumeric
		//open for injection
		$sql = "SELECT *
		FROM
			galleryImages
		WHERE
			UserId=?
		AND
			galleryId = ?";
		$params = array($uid,$id);
		$res = $db->queryAndFetch($sql,$params);
		if($db->RowCount() > 0)
		{
			
			$images = "<h3> Edit </h3><form id='editGalleryForm'method='post' action='parse/editGallery_parse.php'><div class='div_single_gallery'>";
			$i = 0;
			$images .= '<label>Name of gallery: </label><input style="width:300px;"name="name" value=""></input>';
			foreach($res  as $row)
			{

				$images .= '<div class="div_single_edit_gallery">';
				$images .=	/*'<input name="name" '.$i.' value=""></input>*/'
								<input type="hidden"name="id'.$i.'" value="'.$row->id.'"></input>
								<img src="'.$row->image.'" class="single_gallery"/>
								<input name="img'.$i.'" value="'.$row->image.'" type="hidden"></input>
									<p>Description: <textarea name="description'.$i.'">'. $row->description.'</textarea></p><hr/></div>';
									$i++;
			}
			$images .= "<input type='submit' name='submit' value='Submit'> <div></form>";
		}
		else
		{
			$images = displayErrorMessage("YOU DID SOMETHING UNAUTHORISED");
		}
	}
	return $images;
}
?>


<div id="forum_wrapper">
<hr/>
<h2> Gallery <?=showEdit($db)?></h2>
<style>

</style>
<?php
//Dynamic part of file

if(!isset($_GET['page']))
{
	// if SESSION($uid) == userImages id, show edit
	$images = "";
	//if isset, show single gallery
	$image ="";
	if(isset($_GET['galleryId']) && is_numeric($_GET['galleryId']))
	{
		$id = is_numeric($_GET['galleryId']) ? $_GET['galleryId'] : 0;
		//issnumeric
		//open for injection
		$sql = "SELECT * 
		FROM
			galleryImages
		WHERE 
			galleryId=?";
		$params = array($id);
		$res = $db->queryAndFetch($sql,$params);
		$images .= '<div class="div_single_gallery">';
		$i = 0; //ugly as hell
		foreach($res as $row )
		{
			
			/*$images .= '<div class="div_single_gallery">
				<h3>'.$row['name'].'</h3><a href="#3" class="lightbox"><img src="'.$row["image"].'" class="single_gallery"></a>'.$row['description'].'</div>';
				$image = $row['image'];*/
				if($i == 0)
				{
					$images .= '<h3>'.$row->name.'</h3>';
					$i ++;
				}	
				$images .= '<a href="'.$row->image.'"><img src="'.$row->image.'" class="single_gallery"></a>'.$row->description;
				$image = $row->image;
				
		}
	$images .= '</div>';
	//if not, show all galleries
	}
	else
	{


		$sql = "SELECT image,name, galleryId
		FROM
			galleryImages
		GROUP BY 
			galleryId
		HAVING
			COUNT(*)>0";
		$res = $db->queryAndFetch($sql);
		$images = '<div id="parent_image">';
		foreach($res as $row )
		{
			$images .= 
			'<div class="child_image">
				<a href="gallery.php?galleryId='.$row->galleryId.'">
				<img src="'.$row->image.'"/></a><p>'.$row->name.'</p>
			</div>';
		}
		$images .= '<div style="clear:both"></div>';
		$images .= '</div>';
	}	

}
else if(isset($_GET['page']) && $_GET['page'] == 'Edit')
{
	//include('Gallery/editGallery.php');
	$images = editGallery($db);
}
else if((isset($_GET['page']) && $_GET['page'] == 'add') )
{
	include("Gallery/addGallery.php");
	$images = "";
}

echo $images;

?>
<a href="#3" class="lightbox">Open Lightbox</a>
	<div class="backdrop"></div>
	<div class="box"><div class="close">x</div><img src="userImg/Gallery/1/214950_2014-08-31_00005.png" style='width:100%'/></div>

	

</div>