<?php 

class Gallery { 
   
  
/** 
 * Method to display error message. 
 * 
 * @param string $message the error message to display. 
 */ 
function errorMessage($message) { 
  header("Status: 404 Not Found"); 
  die('gallery.php says 404 - ' . htmlentities($message)); 
} 


/** 
 * Read directory and return all items in a ul/li list. 
 * 
 * @param string $path to the current gallery directory. 
 * @param array $validImages to define extensions on what are considered to be valid images. 
 * @return string html with ul/li to display the gallery. 
 */ 
function readAllItemsInDir($path,  $validImages = array('png', 'jpg', 'jpeg','JPG','JPEG','bmp', 'BMP'))  { 
  $files = glob($path . '/*');  
 // $gFolders = "<div style=''>";
  $gallery = "<ul class='gallery' style=''>"; 
  $len = strlen(GALLERY_PATH); 

  foreach($files as $file) { 
    $parts = pathinfo($file); 
     

    // Is this an image or a directory 
    if(is_file($file) && in_array($parts['extension'], $validImages)) { 
      $item = "<img src='img.php?gallery&amp;src=" . GALLERY_BASEURL . substr($file, $len + 1) . "&amp;width=128&amp;height=128&amp;crop-to-fit' alt=''/>"; 
      $caption = basename($file);  
    } 
    elseif(is_dir($file)) { 
  
	  $item    = "<img src='images/slideshow/folder.png' alt=''/>"; 
      $caption = basename($file) . '/'; 
    }
	
    else { 
      continue; 
    } 

    // Avoid to long captions breaking layout 
    $fullCaption = $caption; 
    if(strlen($caption) > 18) { 
      $caption = substr($caption, 0, 10) . '…' . substr($caption, -5); 
    } 

    $href = substr($file, $len + 1); 
	if(!is_dir($file))
		$gallery .= "<li><a href='?gallery&amp;path={$href}' title='{$fullCaption}'><figure class='figure overview'>{$item}</figure></a></li>"; 
	else
		$gallery .= "<li><a href='?gallery&amp;path={$href}' title='{$fullCaption}'><figure class='figure overview'>{$item}<figcaption>{$caption}</figcaption></figure></a></li>";
  } 
  $gallery .= "</ul>"; 
  //$gFolders .= "</div>"; 
  return $gallery; 
} 


/** 
 * Read and return info on choosen item. 
 * 
 * @param string $path to the current gallery item. 
 * @param array $validImages to define extensions on what are considered to be valid images. 
 * @return string html to display the gallery item. 
 */ 
function readItem($path, $validImages = array('png', 'jpg', 'jpeg','JPG','JPEG','gif', 'bmp', 'bmp'))  { 
  $parts = pathinfo($path); 
  if(!(is_file($path) && in_array($parts['extension'], $validImages))) { 
    return "<p>This is not a valid image for this gallery."; 
  } 

  // Get info on image 
  $imgInfo = list($width, $height, $type, $attr) = getimagesize($path); 
  $mime = $imgInfo['mime']; 
  $gmdate = gmdate("D, d M Y H:i:s", filemtime($path)); 
  $filesize = round(filesize($path) / 1024);  

  // Get constraints to display original image 
  $displayWidth  = $width > 800 ? "&amp;width=800" : null; 
  $displayHeight = $height > 600 ? "&amp;height=600" : null; 

  // Display details on image 
  $len = strlen(GALLERY_PATH); 
  $test = substr($path, $len + 1); 
  $href = 'slideshow' . DIRECTORY_SEPARATOR . GALLERY_BASEURL . substr($path, $len + 1); 
  echo $href;
  $item = <<<EOD
<p><img src='img.php?src={$href}{$displayWidth}{$displayHeight}' alt=''/></p> 
<p><img src='images/{$href}'style='width:100%; height:auto;' alt=''/></p> 




EOD;
/*
<p>Original image dimensions are {$width}x{$height} pixels. <a href='images/{$href}'>View original image</a>.</p> 
<p>File size is {$filesize}KBytes.</p> 
<p>Image has mimetype: {$mime}.</p> 
<p>Image was last modified: {$gmdate} GMT.</p> 
*/
  return $item; 
} 



/** 
 * Create a breadcrumb of the gallery query path. 
 * 
 * @param string $path to the current gallery directory. 
 * @return string html with ul/li to display the thumbnail. 
 */ 
function createBreadcrumb($path) { 
  $parts = explode('/', trim(substr($path, strlen(GALLERY_PATH) + 1), '/')); 
  $breadcrumb = "<ul class='breadcrumb'>\n<li><a href='?'>Hem</a> »</li>\n"; 
  
  if(!empty($parts[0])) { 
    $combine = null; 
    foreach($parts as $part) { 
      $combine .= ($combine ? '/' : null) . $part; 
      $breadcrumb .= "<li><a href='?path={$combine}'>$part</a> » </li>\n"; 
    } 
  } 
  
  $breadcrumb .= "</ul>\n"; 
  return $breadcrumb; 
} 
}		