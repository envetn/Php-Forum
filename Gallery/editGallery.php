<?php

$images = "";

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
	$id = $_GET['id'];
	//issnumeric
	//open for injection
	$sql = "SELECT *
	FROM
		galleryImages
	WHERE
		galleryId = ?";
	$params = array($id);
	$res = $db->queryAndFetch($sql,$params);
	
	$images = "<h3> Edit </h3><form method='post' action='parse/editGallery_parse.php'><div class='div_single_gallery'>";
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

?>

<style>



</style>
<?=$images;?>
